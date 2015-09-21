<?php namespace App\Game\Sequences\Phases;

use App\Game\Cards\Minion;
use App\Game\Cards\Triggers\TriggerTypes;

class LateOnSummon extends CardPhase
{
    public $phase_name = 'late_on_summon_phase';

    function queue(Minion $minion, array $targets = []) {
        $player           = $minion->getOwner();
        $player_minions   = $player->getMinionsInPlay();

        foreach ($player_minions as $tmp_minion) {
            if ($minion->getId() == $tmp_minion->getId()) {
                continue;
            }

            if (!$tmp_minion->hasTrigger(TriggerTypes::$LATE_ON_SUMMON_PHASE)) {
                continue;
            }

            $tmp_trigger          = App('LateOnSummon');
            $tmp_trigger->card    = $tmp_minion;
            App('TriggerQueue')->queue($tmp_trigger);
        }
    }
}