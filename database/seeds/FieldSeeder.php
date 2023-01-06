<?php

namespace Database\Seeders;

use App\Repositories\Field\FieldRepository;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    protected $fieldRepo;
    public function __construct(FieldRepository $fieldRepo)
    {
        $this->fieldRepo = $fieldRepo;
    }

    public function run()
    {
        $listItem = [
            [
                'name' => 'Công nghệ thông tin',
            ],
            [
                'name' => 'Chứng khoán đầu tư',
            ],
            [
                'name' => 'Tài chính ngân hàng',
            ],
            [
                'name' => 'Du lịch - Khách sạn',
            ],
            [
                'name' => 'Xây dựng - Bất động sản',
            ],
            [
                'name' => 'Sản xuất chế tạo',
            ],
            [
                'name' => 'Dịch vụ ăn uống'
            ],
            [
                'name' => 'Vận tải hành khách'
            ],
            [
                'name' => 'Logistic (Kho vận)'
            ],
            [
                'name' => 'Luật - tư vấn luật'
            ],
            [
                'name' => 'Bán lẻ'
            ],
            [
                'name' => 'Dược phẩm y tế',
            ],
            [
                'name' => 'Giáo dục - Đào tạo'
            ],
            [
                'name' => 'Dịch vụ online'
            ],
            [
                'name' => 'Thời trang may mặc'
            ],
            [
                'name' => 'Mỹ phẩm làm đẹp'
            ],
            [
                'name' => 'Dịch vụ nhân sự'
            ],
        ];

        foreach ($listItem as $item) {
            $this->fieldRepo->create($item);
        }
    }
}
