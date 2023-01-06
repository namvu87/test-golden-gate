<?php

namespace App\Console\Commands;

use App\Model\Item;
use Illuminate\Console\Command;

class CalculatorGrossItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:total-gross-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrayItem = [];

        $item1 = new Item(3,2.5 , 4.4, 1 , 5.5 , 300);
        $item1_price = $item1->calItemPrice();
        array_push($arrayItem, $item1_price);

        $item2 = new Item(3,2.5 , 4.4, 2.2 , 8);
        $item2_price = $item2->calItemPrice();
        array_push($arrayItem, $item2_price);

        echo array_sum($arrayItem);

        return 1;
    }

}
