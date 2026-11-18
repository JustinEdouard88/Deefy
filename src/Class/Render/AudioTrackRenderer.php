<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;


abstract class AudioTrackRenderer implements Renderer{
	protected AudioTrack $track;

	public function __construct(AudioTrack $track)
	{
		$this->track = $track;
	}

	final public function render(int $selector): string
	{
		$audio = '<audio controls src="'. $this->track->__get("nomFichier") .'"></audio>';

		if ($selector === self::LONG) {
			return $this->renderLong() . $audio;
		}

		return $audio;
	}

	abstract protected function renderLong(): string;
}