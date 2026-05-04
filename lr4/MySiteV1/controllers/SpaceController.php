<?php

class SpaceController extends PageController
{
    public function action_main(): void
    {
        $seed = (int)($_GET['seed'] ?? 123);
        $this->render('space/main', ['seed' => $seed], 'Space Engine');
    }
}
