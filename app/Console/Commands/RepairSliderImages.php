<?php

namespace App\Console\Commands;

use App\Models\Slider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RepairSliderImages extends Command
{
    protected $signature = 'repair:slider-images';
    protected $description = 'Repair slider images URLs for R2 with path style';

    public function handle()
    {
        $sliders = Slider::all();
        $bucket = env('CLOUDFLARE_R2_BUCKET');
        
        foreach ($sliders as $slider) {
            if ($slider->imagen) {
                // Si es solo un path (sin http), convertirlo a URL completa
                if (!str_starts_with($slider->imagen, 'http')) {
                    $slider->imagen = Storage::disk('r2')->url($slider->imagen);
                    $slider->save();
                    $this->info("Reparado slider ID: {$slider->id} - Path a URL");
                }
                // Si ya es una URL pero no es la correcta, verificar
                else {
                    $currentUrl = $slider->imagen;
                    $expectedBase = env('CLOUDFLARE_R2_URL') . '/' . $bucket . '/';
                    
                    if (!str_starts_with($currentUrl, $expectedBase)) {
                        // Reconstruir la URL correcta desde el path
                        $path = $slider->getRawOriginal('imagen'); // Obtener valor original sin mutators
                        if (!str_starts_with($path, 'http')) {
                            $correctUrl = Storage::disk('r2')->url($path);
                            $slider->imagen = $correctUrl;
                            $slider->save();
                            $this->info("Reparado slider ID: {$slider->id} - URL corregida");
                        }
                    }
                }
            }
        }
        
        $this->info('Todos los sliders han sido procesados');
    }
}