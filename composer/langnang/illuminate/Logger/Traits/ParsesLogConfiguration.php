<?php

namespace Illuminate\Logger\Traits;

use InvalidArgumentException;
use Monolog\Logger as Monolog;

trait ParsesLogConfiguration
{
  /**
   * The Log levels.
   *
   * @var array
   */
  protected $levels = [
    'debug' => 100,
    'info' => 200,
    'notice' => 250,
    'warning' => 300,
    'error' => 400,
    'critical' => 500,
    'alert' => 550,
    'emergency' => 600,
  ];

  /**
   * Get fallback log channel name.
   *
   * @return string
   */
  // abstract protected function getFallbackChannelName();

  /**
   * Parse the string level into a Monolog constant.
   *
   * @param  array  $config
   * @return int
   *
   * @throws \InvalidArgumentException
   */
  protected function level(array $config)
  {
    $level = $config['level'] ?? 'debug';

    if (isset($this->levels[$level])) {
      return $this->levels[$level];
    }

    throw new InvalidArgumentException('Invalid log level.');
  }

  /**
   * Parse the action level from the given configuration.
   *
   * @param  array  $config
   * @return int
   */
  protected function actionLevel(array $config)
  {
    $level = $config['action_level'] ?? 'debug';

    if (isset($this->levels[$level])) {
      return $this->levels[$level];
    }

    throw new InvalidArgumentException('Invalid log action level.');
  }

  /**
   * Extract the log channel from the given configuration.
   *
   * @param  array  $config
   * @return string
   */
  protected function parseChannel(array $config)
  {
    return $config['name'] ?? $this->getFallbackChannelName();
  }
}
