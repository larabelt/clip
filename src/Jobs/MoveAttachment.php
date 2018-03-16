<?php

namespace Belt\Clip\Jobs;

use Belt;
use Belt\Clip\Attachment;
use Belt\Clip\Services\MoveService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MoveAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Attachment
     */
    protected $attachment;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var MoveService
     */
    public $service;

    /**
     * @return MoveService
     */
    public function service()
    {
        return $this->service = $this->service ?: new MoveService();
    }

    /**
     * MoveAttachment constructor.
     * @param $attachment
     * @param $target
     * @param array $options
     */
    public function __construct($attachment, $target, $options = [])
    {
        $this->attachment = $attachment;
        $this->target = $target;
        $this->options = $options;
    }

    /**
     * Execute the job
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->service()->move($this->attachment, $this->target, $this->options);
    }

}
