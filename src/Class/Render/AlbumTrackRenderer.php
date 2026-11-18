<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;
use iutnc\deefy\render\AudioTrackRenderer as AudioTrackRenderer;


class AlbumTrackRenderer extends AudioTrackRenderer{
    private AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $at)
    {
        parent::__construct($at);
        $this->albumTrack = $at;
    }

    protected function renderLong(): string
    {
        return "<p>". $this->albumTrack->__get("numPiste") . " - " . $this->albumTrack->__get("titre") . ", " . $this->albumTrack->__get("album") . '</p>';
    }
}