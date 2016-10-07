<?php

namespace Phphub\Handler;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Image;
use Auth;
use Phphub\Handler\Exception\ImageUploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadHandler
{
    /**
     * @var UploadedFile $file
     */
    protected $file;
    protected $allowed_extensions = ["png", "jpg", "gif"];

    /**
     * @param UploadedFile $file
     * @param User $user
     * @return array
     */
    public function uploadAvatar($file, User $user)
    {
        $this->file = $file;
        $this->checkAllowedExtensionsOrFail();

        $avatar_name = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension() ?: 'png';
        $this->saveImageToLocal('avatar', 380, $avatar_name);

        return ['filename' => $avatar_name];
    }

    public function uploadImage($file)
    {
        $this->file = $file;
        $this->checkAllowedExtensionsOrFail();

        $local_image = $this->saveImageToLocal('topic', 1440);

        $type = Config::get('filesystems.default');//获得存储的类型
        if ($type === 'qiniu') {
            return ['filename' => $local_image];
        } else {
            return ['filename' => get_user_static_domain() . $local_image];
        }
    }

    protected function checkAllowedExtensionsOrFail()
    {
        $extension = strtolower($this->file->getClientOriginalExtension());
        if ($extension && !in_array($extension, $this->allowed_extensions)) {
            throw new ImageUploadException('You can only upload image with extensions: ' . implode($this->allowed_extensions, ','));
        }
    }

    protected function saveImageToLocal($type, $resize, $filename = '')
    {
        $folderName = ($type == 'avatar')
            ? 'uploads/avatars'
            : 'uploads/images/' . date("Ym", time()) . '/' . date("d", time()) . '/' . Auth::user()->id;

        $destinationPath = public_path() . '/' . $folderName;
        $extension = $this->file->getClientOriginalExtension() ?: 'png';
        $safeName = $filename ?: str_random(10) . '.' . $extension;
        $this->file->move($destinationPath, $safeName);

        if ($this->file->getClientOriginalExtension() != 'gif') {
            $img = Image::make($destinationPath . '/' . $safeName);
            $img->resize($resize, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save();
        }
        $file = $folderName . '/' . $safeName;
        $type = Config::get('filesystems.default');//获得存储的类型
        if ($type === 'qiniu') {
            $fileqiniu = $this->saveImageToqinniu($file, $safeName);
            // unlink($file);需要优化
            return $fileqiniu;
        } else {
            return $file;
        }
    }

    /**
     * @param $filename 路径
     * @param $safeName 文件名
     */
    protected function saveImageToqinniu($file, $safeName)
    {
        //上传到七牛云储存
        $disk = \Storage::disk('qiniu');
        $content = file_get_contents($file);
        $re = $disk->put($safeName, $content);  //上传文件
        $https = Config::get('filesystems.disks.qiniu.domains.https');//获得配置文件的地址
        return $https . $safeName;
    }
}
