<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            '{"time":1613237329798,"blocks":[{"type":"paragraph","data":{"text":"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, vel accusantium. Sequi numquam exercitationem nisi nemo porro dolorem fuga nihil vero? Minus earum incidunt iste quaerat laudantium saepe doloribus totam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus enim qui exercitationem facere veritatis, voluptate necessitatibus eaque ratione dolores ab laborum velit temporibus blanditiis deleniti suscipit, explicabo quae aliquam. Nulla"}}],"version":"2.19.1"}',
            '{"time":1613249686439,"blocks":[{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/10451613249686.jpeg","caption":"13925050_1138201009583424_5952986908756455959_n.jpg","withBorder":false,"withBackground":false,"stretched":false}},{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/71921613249686.jpeg","caption":"15578472_1276140222456168_7474206119183268460_n.jpg","withBorder":false,"withBackground":false,"stretched":false}}],"version":"2.19.1"}',
            '{"time":1612222983619,"blocks":[{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/80081612173468.png","caption":"Annotation 2019-11-17 030818.png","withBorder":false,"withBackground":false,"stretched":false}},{"type":"paragraph","data":{"text":"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, vel accusantium. Sequi numquam exercitationem nisi nemo porro dolorem fuga nihil vero? Minus earum incidunt iste quaerat laudantium saepe doloribus totam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus enim qui exercitationem facere veritatis, voluptate necessitatibus eaque ratione dolores ab laborum velit temporibus blanditiis deleniti suscipit, explicabo quae aliquam. Nulla."}},{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/55581612173468.png","caption":"hamza.png","withBorder":false,"withBackground":false,"stretched":false}},{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/24931612175110.jpeg","caption":"BluebirdsYNP_FR-FR1597350662_1920x1080.jpg","withBorder":false,"withBackground":false,"stretched":false}}],"version":"2.19.1"}',
            '{"time":1612222983619,"blocks":[{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/80081612173468.png","caption":"Annotation 2019-11-17 030818.png","withBorder":false,"withBackground":false,"stretched":false}},{"type":"paragraph","data":{"text":"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, vel accusantium. Sequi numquam exercitationem nisi nemo porro dolorem fuga nihil vero? Minus earum incidunt iste quaerat laudantium saepe doloribus totam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus enim qui exercitationem facere veritatis, voluptate necessitatibus eaque ratione dolores ab laborum velit temporibus blanditiis deleniti suscipit, explicabo quae aliquam. Nulla."}},{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/55581612173468.png","caption":"hamza.png","withBorder":false,"withBackground":false,"stretched":false}},{"type":"image","data":{"url":"http:\/\/app.test\/storage\/uploads\/24931612175110.jpeg","caption":"BluebirdsYNP_FR-FR1597350662_1920x1080.jpg","withBorder":false,"withBackground":false,"stretched":false}}],"version":"2.19.1"}'
        ];
        return [
            'title' => $this->faker->text(50),
            'user_id' => rand(1, 3),
            'publish' => '2020-11-28T21:33:52',
            'content' => $data[rand(0, 3)]
        ];
    }
}
