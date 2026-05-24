<?php

namespace App\Http\Controllers;

use App\Models\SermonMedia;
use App\Models\SermonShareLink;
use App\Models\SermonView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SermonShareController extends Controller
{
    public function show(Request $request, string $token)
    {
        $shareLink = SermonShareLink::query()
            ->with(['sermon.category', 'sermon.series', 'sermon.preacher', 'sermon.media'])
            ->where('token', $token)
            ->firstOrFail();

        abort_if($shareLink->isExpired(), 404);
        abort_if($shareLink->sermon->status !== 'published', 404);

        $shareLink->increment('view_count');
        $shareLink->update(['last_viewed_at' => now()]);
        $shareLink->sermon->increment('view_count');

        SermonView::query()->create([
            'sermon_id' => $shareLink->sermon_id,
            'source' => 'share',
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'viewed_at' => now(),
        ]);

        $media = $shareLink->sermon->media->firstWhere('is_primary', true) ?: $shareLink->sermon->media->first();

        return view('sermons.share', [
            'shareLink' => $shareLink,
            'sermon' => $shareLink->sermon,
            'media' => $media,
        ]);
    }

    public function download(string $token, SermonMedia $media)
    {
        $shareLink = SermonShareLink::query()->with('sermon')->where('token', $token)->firstOrFail();

        abort_if($shareLink->isExpired(), 404);
        abort_if($media->sermon_id !== $shareLink->sermon_id, 404);
        abort_if(! $shareLink->allow_download && ! $shareLink->sermon->allow_download && ! $media->allow_download, 403);
        abort_if($media->source !== 'upload' || blank($media->file_path), 404);

        $shareLink->sermon->increment('download_count');

        return Storage::disk($media->disk ?: 'public')->download($media->file_path);
    }
}
