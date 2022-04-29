<?php

/**********************************************************************
 * Direct Axis Technology L.L.C.
 * Released under the terms of the GNU General Public License, GPL,
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
 ***********************************************************************/

namespace BipinKareparambil\ImageUploadLaravel;

use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

Class ImageUploadLaravel
{

    private string $uploadPath;
    private string $thumbPath;

    public function __construct()
    {
        $this->uploadPath = env('IMAGE_UPLOAD_PATH');
        $this->thumbPath = $this->uploadPath . 'thumb/';
    }

    /**
     * Upload multiple files
     * @param Request $request
     * @param string $disk
     * @return array
     */
    public function multipleImageUpload(Request $request,  $disk = "public")
    {
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0775);
            mkdir($this->thumbPath, 0775);
        }

        $paths = [];

        foreach ($request->all() as $key => $value) {

            if ($request->hasFile($key)) {
                $files = $request->file($key);
                foreach ($files as $file) {
                    $path = $this->doUpload($file,$disk);
                    $paths[$key][] = $path;
                }
            }
        }

        return $paths;
    }


    /**
     * Upload single file
     * @param Request $request
     * @param string $disk
     * @return array
     */
    public function singleImageUpload(Request $request, $disk = "public")
    {

        $paths = [];
        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $this->doUpload($file,$disk);

                $paths[$key] = $path;
            }
        }
        return $paths;
    }


    /**
     * Upload functionality
     * @param $file
     * @param $disk
     * @return bool|string
     */
    public function doUpload($file,$disk)
    {
        $originalFileName = $file->getClientOriginalName();
        $originalFileExtension = $file->getClientOriginalExtension();
        $fileMime = $file->getMimeType();
        $fileContent = $file->getContent(); // File binary data

        $fileName = 'img-' .$originalFileName. time() . '.' . $originalFileExtension;

        $storageDisk = Storage::disk($disk);

        //Generate and save image thumb file
        $thumbFile = Image::make($file)->resize(50, 50);
        $filePath = $this->thumbPath . $fileName;
        $storageDisk->put($filePath, $thumbFile->__toString(), 'public');

        //Saving the original file
        $filePath = $this->uploadPath . $fileName;
        $storageDisk->put($filePath, $fileContent, 'public');

        return $filePath;

    }
}
