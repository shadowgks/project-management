<?php
            namespace Modules\Tasks\Entities;

            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use App\Models\Reminder;
            use App\Models\File;
            use App\Models\Comment;
            use App\Models\User;

            use App\Models\Status;
class Task extends Model
            {
                use HasFactory;

            
protected $table = "tasks";
protected $fillable = ["id",
"title", 
"description", 
"start_date", 
"end_date", 
"priority_id", 
"status_id",
"created_at",
                "updated_at",
                ];
public $timestamps = true;


            public function created_by(){
                return $this->belongsTo(User::class, "user_id");
            }

                public function status(){
                    return $this->hasone(Status::class,"status_id","id");
                }
            
            public function comments(){
                return $this->hasMany(Comment::class,"app_module_id","id");
            }

            public function files(){
                return $this->hasMany(Upload::class,"app_module_id","id");
            }

            public function reminders(){
                return $this->hasMany(Reminder::class,"app_module_id","id");
            }

            // Relations

                    public function drop_downs()
                    {
                        return $this->belongsTo(\App\Models\DropDown::class, "priority_id");
                    }
                }