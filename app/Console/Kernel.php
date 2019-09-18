<?php

namespace siga\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use siga\Modelo\insumo\Stock;
use siga\Modelo\insumo\Stock_Historial;
use siga\Http\Modelo\ProductoTerminado\stock_pt;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function (){
           
            $stock = Stock::get();
            foreach ($stock as $st) {
                // dd($st->stockal_id);
                DB::table('insumo.stock_historial')->insert(
                    ['his_stock_ins_id' => $st->stock_ins_id, 'his_stock_planta_id' => $st->stock_planta_id, 'his_stock_cant' => $st->stock_cantidad,'his_stock_cant_ingreso'=>0,'his_stock_cant_salida'=>0,'his_stock_usr_id'=>'1','his_stock_estado'=>'A']
                );
            }
            /*STOCK PRODUCTO TERMINADO*/
            $stock_pt = stock_pt::get();
            foreach ($stock_pt as $spt) {
                DB::table('producto_terminado.stock_producto_terminado_historial')->insert(
                    [
                        'spth_orprod_id'        =>$spt->spt_orprod_id,
                        'spth_planta_id'        =>$spt->spt_planta_id,
                        'spth_fecha'            =>$spt->spt_fecha,
                        'spth_cantidad'         =>$spt->spt_cantidad,
                        'spth_costo'            =>$spt->spt_costo,
                        'spth_costo_unitario'   =>$spt->spt_costo_unitario,
                        'spth_usr_id'           =>$spt->spt_usr_id,
                        'spth_registrado'       =>$spt->spt_registrado,
                        'spth_modificado'       =>$spt->spt_modificado,
                        'spth_estado_baja'      =>$spt->spt_estado_baja,
                    ]
                );
            }       
        })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
