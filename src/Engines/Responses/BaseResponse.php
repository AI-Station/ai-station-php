<?php

namespace AIStation\Engines\Responses;

class BaseResponse
{
    protected int $predictionDurationMs;

    /**
     * Returns the amount of milliseconds it took to make the prediction
     * @return int
     */
    public function getPredictionDurationMs(): int
    {
        return $this->predictionDurationMs;
    }

}
