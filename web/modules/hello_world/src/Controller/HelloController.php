<?php

declare(strict_types=1);

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Hello, World routes.
 */
final class HelloController extends ControllerBase {

  /**
   * Builds the response.
   */
  /*  adding custom code in a name var to print hello and you name
  if you go to the route /hello-world/enter a name i.e hello-world/matt
  in the hello_world.routing.yml file we added this configs to make this work*/
  public function __invoke($name): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Hello @name!', ['@name' => $name]),
    ];

    return $build;
  }

}
