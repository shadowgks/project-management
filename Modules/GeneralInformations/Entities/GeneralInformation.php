<?php
            namespace Modules\GeneralInformations\Entities;

            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use App\Models\Reminder;
            use App\Models\File;
            use App\Models\Comment;
            use App\Models\User;

            class GeneralInformation extends Model
            {
                use HasFactory;

            
protected $table = "general_informations";
protected $fillable = ["id",
"name", 
"description", 
"type", 
"start_date", 
"finish_date", 
"created_at",
                "updated_at",
                ];
public $timestamps = true;


            public function created_by(){
                return $this->belongsTo(User::class, "user_id");
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
}