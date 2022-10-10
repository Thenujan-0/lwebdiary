<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DiaryEntry;
use App\Models\User;
use Exception;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiaryEntry>
 */
class DiaryEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = DiaryEntry::class;
    public function definition()
    {
    $targetUser =User::all()->random();
    // try{
    //     $diaryNames = $targetUser->diaryNames();
    // }catch(Exception $err){
    //     echo $err->getMessage();
    //     echo "caught exception";
    // }
    echo "caught exception";

        return [
            'user_id'=>$targetUser->id,
            'diary_name_id'=>"633a5d65ad9b76eb9b007e43",
            'date'=>$this->faker->date(),
            'data'=>$this->faker->text()
        ];
    }
}
