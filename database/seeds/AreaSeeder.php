<?php

use App\Models\Area;
use Illuminate\Database\Seeder;
use Overtrue\LaravelPinyin\Facades\Pinyin;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area_json_file = database_path() . '/area.json';
        if (!file_exists($area_json_file)) {
            $this->command->error("地区数据文件不存在！");
        } else {
            if (!$this->command->confirm('导入地区数据会把原有通过管理后台手动添加的地区数据清空。您任然继续导入地区数据？')) {
                exit;
            }
            \DB::table('areas')->truncate();
            $areas = decode_json_data(file_get_contents($area_json_file));
            if (empty($areas)) {
                $this->command->error("地区数据解析失败！");
            } else {
                $this->command->info('地区数据正在导入中...');
                foreach ($areas as $area) {
                    $this->store_data($area, 0, 0);
                }
                $this->command->info('地区数据导入成功！');
            }
        }
    }

    private function store_data($data, $pid, $type)
    {
        $name = $data['name'];
        $letter = substr(Pinyin::abbr($name), 0, 1);

        $area = Area::create([
            'pid'   => $pid,
            'type'  => $type,
            'name'  => $name,
            'first_letter' => strtoupper($letter),
        ]);

        $children = isset($data['children']) ? $data['children'] : '';
        if (!empty($children)) {
            $type = $type + 1;
            foreach ($children as $index => $child) {
                $this->store_data($child, $area->id, $type);
            }
        }
    }
}
