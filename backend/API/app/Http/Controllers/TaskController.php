<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskTerminatedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        $tasks=Task::all();
    return response()->json([
        'tasks'=>$tasks,
        'message'=>'success',
        'code'=>200
        ]);
        
    }
    public function show(){
        $task=Task::get();
    return response()->json([
        'task'=>$task,
        'message'=>'success',
        'code'=>200
        ]);
        
    }
    
    public function MyTask(){
       
        
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'code' => 401
            ], 401);
        }
       
        $tasks = $user->assigned;

        return response()->json([
            'tasks' => $tasks,
            'message' => 'success',
            'code' => 200
        ]);
        
    }
    public function create()
{
   
    $data = [
        'message' => 'Form for creating a new task',
        'fields' => [
            'name' => '',
            'description' => '',
            'start_date' => '',
            'due_date' => '',
            
        ]
    ];

    return response()->json($data, 200);
}
public function store(TaskRequest $request)
{
    $userId = Auth::id();
   

  
    $task = Task::create([
        'name' => $request->input('name'),
        'start_date' =>$request->input('start_date'),
        'due_date' => $request->input('due_date'),
        'description' => $request->input('description'),
        'user_created_by' => $userId,
       
    ]);

    // Retourner une réponse JSON
    return response()->json([
        'message' => 'Task created successfully',
        'task' => $task
    ], 201);
}
public function edit(Task $task)
{
    return response()->json([
        'task' => $task
    ]);
}
public function update(Task $task, TaskRequest $request){

  
    
    $task->update($request->validated());
    return response()->json([
        'message' => 'Task updated successfuly',
        'task' => $task
    ], 200); 

}
public function destroy(Task $task){
    try {
        $task->delete();
        return response()->json([
            'message' => 'Task successfuly deleted'
        ], 200); 
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la suppression de la tâche',
            'error' => $e->getMessage()
        ], 500); 
    }
}
public function assignView(Task $task)
{
    try {
        // Récupérer uniquement les utilisateurs avec le rôle 'user'
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('name', 'user');
        })->get();

        // Formater la réponse
        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->pluck('name')->toArray(),
            ];
        });

        return response()->json([
            'task' => $task,
            'users' => $formattedUsers,
        ], 200); // Ajouter un code de statut HTTP 200 pour indiquer le succès

    } catch (\Exception $e) {
        // Gérer les erreurs et retourner une réponse appropriée
        return response()->json([
            'error' => 'Une erreur s\'est produite lors de la récupération des utilisateurs.',
            'message' => $e->getMessage(), // Inclure le message d'erreur pour le débogage
        ], 500); // Code de statut HTTP 500 pour indiquer une erreur serveur
    }
}


public function assign(Task $task, Request $request)
{
    $request->validate([
        'user_assigned_to' => ['required', 'exists:users,id'],
    ]);

    $user_assigned_to = $request->input('user_assigned_to');
    $user = User::find($user_assigned_to);

    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
    }

    $occupied = $user->assigned()
        ->where(function (Builder $query) use ($task) {
            $query->where(function ($sub) {
                $sub->where('status', 'en cours')
                    ->orWhere('status', 'en attente');
            })
            ->where('start_date', '<', $task->due_date)
            ->where('due_date', '>', $task->start_date);
        })
        ->exists();

    if ($occupied) {
        return response()->json(['error' => "{$user->name} est occupé"], 422);
    }

    // Attribuer la tâche
    $task->user_assigned_to = $user_assigned_to;
    $task->status = 'en attente';
    $task->save();

   
    $user->notify(new TaskAssignedNotification($task));
    return response()->json(['message' => 'Tâche attribuée avec succès'], 200);
}



 public function startTask(Task $task)
    {
        $task->status = 'en cours';
        $task->save();

        return response()->json(['message' => 'Task started successfully', 'task' => $task], 200);
    }

    public function markAsTerminated(Task $task)
    {  
        $user=User::find($task->user_created_by);
        $task->status = 'terminer';
        $task->save();
       
        $user->notify(new TaskTerminatedNotification($task));
        return response()->json(['message' => 'Task marked as terminated successfully', 'task' => $task], 200);
    }
    public function notifications(Request $request)
    {
        // Assurez-vous que l'utilisateur est authentifié
        $user = $request->user();

        // Récupérer les notifications pour l'utilisateur authentifié
        $notifications = $user->notifications()->latest()->get();

        return response()->json([
            'notifications' => $notifications,
        ]);
    }
    public function showNotification($id, Request $request)
{
    // Assurez-vous que l'utilisateur est authentifié
    $user = $request->user();

    // Récupérer la notification par son ID
    $notification = $user->notifications()->findOrFail($id);

    return response()->json([
        'notification' => $notification,
    ]);
}
public function markAsRead($id, Request $request)
{
    // Assurez-vous que l'utilisateur est authentifié
    $user = $request->user();

    // Récupérer la notification par son ID
    $notification = $user->notifications()->findOrFail($id);

    // Marquer la notification comme lue
    $notification->markAsRead();

    return response()->json([
        'message' => 'Notification marquée comme lue',
    ]);
}


}
