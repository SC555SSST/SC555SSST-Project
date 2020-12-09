<?php


namespace App\Repositories;
use  App\Models\Thread;
use Illuminate\Support\Facades\DB;

class ThreadRepository
{
    public function findByThreadName($threadName){
        return Thread::where('title', $threadName)->get();
    }

    public function findById($id){
        return Thread::find($id);
    }

    public function findAll(){
        return Thread::all();
    }

    public function findThreadCategories(Thread $thread){
        $arr = array();
        foreach ($thread->categories as $cat){
            $arr[] = array('id'=>$cat->id, 'category_name'=> $cat->category_name);
        }
        return $arr;
    }


    public function add($title,$text,$userId,$categoryArr){

        try
        {
            DB::beginTransaction ();

            $thread = new Thread;
            $thread->title = $title;
            $thread->text = $text;
            $thread->user_id = $userId;
            $thread->save ();
            $id = $thread->id;

            foreach ($categoryArr as $category){
                $thread->categories ()->attach ($category);
                $thread->save ();
            }
            DB::commit();
            return array('isInserted' =>true,'id'=>$id);

        }catch (\PDOException $e) {
            DB::rollBack();
            return array('isInserted' =>false,'id'=>null);
        }

    }

    public function updateById($title,$text,$userId,$categoryArr,$threadId){

        $selectedRow = $this->findById($threadId);
        if($selectedRow){

            try
            {
                DB::beginTransaction ();
                $selectedRow->title = $title;
                $selectedRow->text  = $text;
                $selectedRow->user_id = $userId;
                $selectedRow->save();

                //change categories in pivot table
                $categoryRepository = new CategoryRepository();
                $categoryRepository->synThreadCategories($selectedRow,$categoryArr);

                DB::commit();
                return array('isUpdated' =>true,'id'=>$threadId);

            }catch (\PDOException $e) {
                DB::rollBack();
                return array('isUpdated' =>false,'id'=>null);
            }
        }else{
            return null;
        }
    }

    public function deleteById($id){

        try
        {
            DB::beginTransaction ();

            $thread = $this->findById($id);
            $thread->categories()->detach();
            $thread->delete($id);

            DB::commit();
            return array('isDelete' =>true,'id'=>$id);

        }catch (\PDOException $e) {
            DB::rollBack();
            return array('isDelete' =>false,'id'=>$id);
        }
    }
}
