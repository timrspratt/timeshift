<?php

namespace Timrspratt\Timeshift;

use Aero\Common\Services\TimeMachine as BaseTimeMachine;
use Carbon\CarbonInterface;

class TimeMachine extends BaseTimeMachine
{
    protected $shift;

    public function setShift(int $shift): void
    {
        $this->shift = $shift;
    }

    public function getShift(): ?int
    {
        return $this->shift;
    }

    public function now($tz = null): CarbonInterface
    {
        return $this->getShiftedNow($this->shift, $tz);
    }

    public function getShiftedNow(?int $stamp = null, $tz = null): CarbonInterface
    {
        $now = parent::now($tz);

        if ($stamp > 0) {
            return $now->addSeconds($stamp);
        }

        if ($stamp < 0) {
            return $now->subSeconds(abs($stamp));
        }

        return $now;
    }
}
