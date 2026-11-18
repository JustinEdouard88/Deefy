<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;

class PodcastTrackRenderer extends AudioTrackRenderer{

    public function __construct(PodcastTrack $pt)
    {
        parent::__construct($pt);
    }

    protected function renderLong(): string
    {
        return "<p>". $this->track->__get("titre") . '</p>';
    }
}