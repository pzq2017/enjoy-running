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
            $this->command->error("Regional data file does not exist!");
        } else {
            if (!$this->command->confirm('Importing area data will empty the original area data added manually through the management background. Are you still importing regional data?')) {
                exit;
            }
            \DB::table('areas')->truncate();
            $areas = decode_json_data(file_get_contents($area_json_file));
            if (empty($areas)) {
                $this->command->error("Failed to parse regional data!");
            } else {
                $this->command->info('Regional data is being imported.');
                foreach ($areas as $area) {
                    $this->store_data($area, 0, 0);
                }
                $this->command->info('Regional Data Import Successful!');
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
