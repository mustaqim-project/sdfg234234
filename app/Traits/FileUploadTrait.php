<?php



namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads'): ?string
    {
        // Check if request has file
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        // Delete the existing image if exists
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();

        // Generate filename based on title or random if title is empty
        $fileName = $request->filled('title')
            ? Str::slug($request->title) . '.' . $extension
            : Str::random(30) . '.' . $extension;

        // Move the uploaded file to the directory
        $filePath = $file->move(public_path($dir), $fileName);

        // Convert to WebP and optimize image
        $webpPath = $this->convertAndOptimizeImage($dir . '/' . $fileName);

        // Delete original image file
        File::delete($filePath);

        return $webpPath;
    }

    /**
     * Convert image to WebP format and optimize it
     */
    private function convertAndOptimizeImage(string $imagePath): ?string
    {
        $absolutePath = public_path($imagePath);
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath);
        $absoluteWebpPath = public_path($webpPath);

        // Convert to WebP format using Spatie Image
        Image::load($absolutePath)
            ->format('webp')
            ->save($absoluteWebpPath);

        // Optimize the WebP image using Spatie Image Optimizer
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($absoluteWebpPath);

        return $webpPath;
    }

    /** Handle file delete */
    public function deleteFile(string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}


// namespace App\Traits;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;
// use Spatie\Image\Image;
// use Spatie\ImageOptimizer\OptimizerChainFactory;

// trait FileUploadTrait
// {
//     public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads'): ?string
//     {
//         // Check if request has file
//         if (!$request->hasFile($fieldName)) {
//             return null;
//         }

//         // Delete the existing image if exists
//         if ($oldPath && File::exists(public_path($oldPath))) {
//             File::delete(public_path($oldPath));
//         }

//         $file = $request->file($fieldName);
//         $extension = $file->getClientOriginalExtension();

//         // Generate filename based on title or random if title is empty
//         $fileName = $request->filled('title')
//             ? Str::slug($request->title) . '.' . $extension
//             : Str::random(30) . '.' . $extension;

//         // Move the uploaded file to the directory
//         $filePath = $file->move(public_path($dir), $fileName);

//         // Convert to WebP and optimize image
//         $webpPath = $this->convertAndOptimizeImage($dir . '/' . $fileName);

//         // Delete original image file
//         File::delete($filePath);

//         return $webpPath;
//     }

//     /**
//      * Convert image to WebP format and optimize it
//      */
//     private function convertAndOptimizeImage(string $imagePath): ?string
//     {
//         $absolutePath = public_path($imagePath);
//         $webpPath = preg_replace('/\.(webp|jpg|jpeg|png)$/i', '.webp', $imagePath);
//         $absoluteWebpPath = public_path($webpPath);

//         // Convert to WebP format using Spatie Image
//         Image::load($absolutePath)
//             ->format('webp')
//             ->save($absoluteWebpPath);

//         // Optimize the WebP image using Spatie Image Optimizer
//         $optimizerChain = OptimizerChainFactory::create();
//         $optimizerChain->optimize($absoluteWebpPath);

//         return $webpPath;
//     }

//     /** Handle file delete */
//     public function deleteFile(string $path): void
//     {
//         if ($path && File::exists(public_path($path))) {
//             File::delete(public_path($path));
//         }
//     }
// }
