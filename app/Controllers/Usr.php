<?php

namespace App\Controllers;

use App\Models\Project_Mod;
use App\Models\Inv_Mod;
use App\Models\Task_Mod;
use App\Models\TaskHistory_Mod;
use  App\Models\Team_Mod;
use App\Models\Submission_Mod;
use App\Models\User_Mod;
use App\Models\Verif_Code_Mod;
use App\Models\Post_Mod;

class Usr extends BaseController
{
    protected $session;
    protected $uri;
    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->uri = \config\Services::request();
        helper('form','url');
    }

    public function dev_info()
    {
        return view('usr/dev-info');
    }

    public function profile($username)
    {
        $user = new User_Mod();
        $user->select('name,username,email,IDuser');
        $user->where('username',$username);
        $data['profile'] = $user->first();

        $user1 = new User_Mod();
        $user1->select('project.name,');
        $user1->join('team','team.IDuser = user.IDuser');
        $user1->join('project','project.IDproject = team.IDproject');
        $user1->where('user.username',$username);
        $data['project'] = $user1->get()->getResult();

        return view('usr/profile',$data);
    }

    public function mail_reset_password()
    {
        $email = \Config\Services::email();
        $code = $this->generate_random_code();

        $verif = new Verif_Code_Mod();
        $verif->insert([
            'IDuser' => $this->session->IDuser,
            'code' => $code,
            'description' => 'password',
        ]);
        $message = view('usr/email/password-reset.html');
        $message1 = '<h1>Code for password reset</h1>
                    <div class="code">
                        <center>'.$code.'</center>
                    </div>
                    <div class="content">
                        *Do not reply to this email. <a href="https://steplane.my.id" target="blank"> steplane.my.id</a>
                    </div>';
        $email->setFrom('steplane.id@gmail.com','Steplane');
        $email->setTo(session()->email);
        $email->setSubject('Reset Password Steplane');
        $email->setMessage($message.$message1);
        if($email->send()) {
            $this->session->setFlashdata('scs', 'Please check email. Verification code have been sent code to your email ');
            return redirect()->to(base_url('/email-verification'));
        }else{
            echo 'email fail';
        }
    }

    public function mail_new_email()
    {
        $validation =  \Config\Services::validation();
        if(!empty($_POST)) {
            $validation->setRules([
                'email' => [
					'rules' => 'required|valid_email|is_unique[user.email]',
					'errors' => [
						'required' => 'Email is required',
						'valid_email' => 'Please use valid email',
						'is_unique' => 'This email is already registered with other account'
					]
				],
            ]);

            $isValid = $validation->withRequest($this->request)->run();
            if($isValid){
                $new_email = $this->request->getVar('email');
                if($new_email == $this->session->email){
                    return redirect()->to(base_url('/steplane-profile').'/'.$this->session->username);
                }else{
                    $email = \Config\Services::email();
                    $code = $this->generate_random_code();

                    $verif = new Verif_Code_Mod();
                    $verif->insert([
                        'IDuser' => $this->session->IDuser,
                        'code' => $code,
                        'description' => $new_email,
                        'type' => 'email',
                    ]);
                    $message = view('usr/email/password-reset.html');
                    $message1 = '<h1>Code for verifying new email</h1>
                                <div class="code">
                                    <center>'.$code.'</center>
                                </div>
                                <div class="content">
                                    *Do not reply to this email. <a href="https://steplane.my.id" target="blank"> steplane.my.id</a>
                                </div>';
                    $email->setFrom('steplane.id@gmail.com','Steplane');
                    $email->setTo($new_email);
                    $email->setSubject('Reset Password Steplane');
                    $email->setMessage($message.$message1);
                    if($email->send()) {
                        $this->session->setFlashdata('scs', 'Please check email. Verification code have been sent code to your email ');
                        return redirect()->to(base_url('/email-verification'));
                    }else{
                        echo 'email fail';
                    }
                }
            }else{
                $this->session->setFlashdata('error', $validation->listErrors());
                return redirect()->to(base_url('/update-email/form'));
            }
        }
    }

    public function update_email()
    {
        return view('usr/update-email');
    }

    public function generate_random_code() { 

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
        srand((double)microtime()*1000000); 
        $i = 0; 
        $code = '' ; 
    
        while ($i <= 3) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $code = $code . $tmp; 
            $i++; 
        } 
    
        return $code; 
    }

    public function email_verify()
    {
        if(!empty($_POST)) {
            $verif = new Verif_Code_Mod();
            $verif->select('IDuser,code,type,description');
            $verif->where('IDuser',$this->session->IDuser);
            $data = $verif->first();

            $code_client = $this->request->getVar('code');
            $code_secret = $data['code'];

            if($code_client == $code_secret){
                if($data['type'] == 'password'){
                    return redirect()->to(base_url('/reset-password/new-password'));
                }elseif($data['type'] == 'email'){
                    $verif = new Verif_Code_Mod();
                    $data = $verif->where('IDuser',$this->session->IDuser)->first();
                    $new_email = $data['description'];
                    $user = new User_Mod();
                    $user->set('email',$new_email);
                    $user->where('IDuser',$this->session->IDuser);
                    $user->update();

                    $data = $user->where('IDuser',$this->session->IDuser)->first();
                    $session_data = [
                        'email' => $new_email,
                    ];
                    session()->set($session_data);

                    $verif->where('IDuser',$this->session->IDuser);
                    $verif->delete();
                    
                    $this->session->setFlashdata('scs', 'Email updated');
                    return redirect()->to(base_url('/steplane-profile'.'/'.$this->session->username));
                }
            }else{
                $this->session->setFlashdata('error', 'Code not macth');
                return redirect()->to(base_url('/email-verification'));
            }
        }else{
            return view('usr/email-verify');
        }
    }

    public function reset_password()
    {
        $validation =  \Config\Services::validation();
        if(!empty($_POST)) {
            $validation->setRules([
                'pass' => [
					'rules' => 'max_length[15]|required|pass_check[6]',
					'errors' => [
						'required' => 'Password is required'
					]
				],
            ]);

            $isValid = $validation->withRequest($this->request)->run();

            if($isValid){
                $verif = new Verif_Code_Mod();
                $verif->where('IDuser',$this->session->IDuser);
                $verif->delete();

                $user = new User_Mod();
                $user->set([
                    'password' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
                ]);
                $user->where('IDuser',$this->session->IDuser);
                $user->update();

                $this->session->setFlashdata('scs', 'Password updated');
                return redirect()->to(base_url('/steplane-profile'.'/'.$this->session->username));
            }else{
                $this->session->setFlashdata('error', $validation->listErrors());
                return redirect()->to(base_url('/reset-password/new-password'));
            }
        }
        return view('usr/password-reset');
    }

    public function update_profile()
    {
        if(!empty($_POST)) {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'name' => [
					'rules' => 'required|char_only[name]',
					'errors' => [
						'required' => 'Full name is required',
                        'char_only' => 'Name not allowed using special character'
					]
				],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'username is required',
                    ]
                ],
            ]);

            $isValid = $validation->withRequest($this->request)->run();
            $user = new User_Mod();
            $new_username = strtolower($this->request->getVar('username'));

            if($isValid){
                if($this->session->username == $new_username && $this->session->name != $this->request->getVar('name')){
                    $user->set([
                        'name' => $this->request->getVar('name')
                    ]);
                    $user->where('IDuser',$this->session->IDuser);
                    $user->update();

                    $data = $user->where('IDuser',$this->session->IDuser)->first();
                    $session_data = [
						'username' => $data['username'],
						'name' => $data['name'],
					];
                    session()->set($session_data);

                    $this->session->setFlashdata('scs', 'Profile updated');
                    return redirect()->to(base_url('/steplane-profile'.'/'.$this->session->username));
                }else if($this->session->username != $new_username){
                    $user = new User_Mod();
                    $user->select('username');
                    $user->where('username',$new_username);
                    $data = $user->first();

                    if($data != null){
                        $this->session->setFlashdata('error', 'This username is already taken');
                        return redirect()->to(base_url('/edit-profil'));
                    }else{
                        $user->set([
                            'name' => $this->request->getVar('name'),
                            'username' => $new_username,
                        ]);
                        $user->where('IDuser',$this->session->IDuser);
                        $user->update();

                        $data = $user->where('IDuser',$this->session->IDuser)->first();
                        $session_data = [
                            'username' => $data['username'],
                            'name' => $data['name'],
                        ];
                        session()->set($session_data);
                        $this->session->setFlashdata('scs', 'Profile updated');
                        return redirect()->to(base_url('/steplane-profile'.'/'.$this->session->username));
                    }
                }else{
                    return redirect()->to(base_url('/steplane-profile'.'/'.$this->session->username));
                }
            }
        }
        return view('usr/profile-edit');
    }

    public function project()
    {
        $team1 = new Team_Mod();
        $team1->select('user.name, project.IDproject, taskhistory.time, task.title, taskhistory.activity,taskhistory.description');
        $team1->join('project','project.IDproject = team.IDproject');
        $team1->join('task','task.IDproject = project.IDproject');
        $team1->join('taskhistory','taskhistory.IDtask = task.IDtask');
        $team1->join('user','user.IDuser = taskhistory.IDuser');
        $team1->where('team.IDuser',$this->session->IDuser);
        $team1->orderBy('taskhistory.time','DESC');
        $team1->limit(1);
        $data['history'] = $team1->get()->getResult();

        $team = new Team_Mod();
        $team->select('project.IDproject, project.name');
        $team->join('project','project.IDproject = team.IDproject');
        $team->where('team.IDuser',$this->session->IDuser);
        $data['project'] = $team->findAll();
        
		return view('usr/project-list',$data);
    }

    public function dasboard($IDproject)
    {

        $data['url'] = $this->uri->uri->getSegment(1);

        $post = new Post_Mod();
        $post->select('IDpost,user.name,content,post.date');
        $post->join('project','project.IDproject = post.IDproject');
        $post->join('user','user.IDuser = post.IDuser');
        $post->where('post.IDproject',$IDproject);
        $data['post'] = $post->findAll();

        $task = new Task_Mod();
        $task->select('taskhistory.description,user.name,activity,time');
        $task->join('taskhistory','taskhistory.IDtask = task.IDtask');
        $task->join('project','project.IDproject = task.IDproject');
        $task->join('user','user.IDuser = taskhistory.IDuser');
        $task->where('task.IDproject',$IDproject);
        $task->orderBy('time','DESC');
        $task->limit(10);
        $data['history'] = $task->findAll();

        $role = new Team_Mod();
        $role->select('role');
        $role->where('IDuser',$this->session->IDuser);
        $role->where('IDproject',$IDproject);
        $data['role'] = $role->first();

        $project = new Project_Mod();
        $project->select('IDproject,name,description');
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();

        return view('usr/project-dasboard-v2',$data);
    }

    public function update_project($IDproject)
    {
        $data['url'] = $this->uri->uri->getSegment(1);

        if(!empty($_POST)){
            $project = new Project_Mod();
            $validation =  \Config\Services::validation();

            $validation->setRules([
                'name' => ['Project name' => 'name', 'rules' => 'required'],
            ]);
            $isValid = $validation->withRequest($this->request)->run();

            if($isValid){
                $project->set([
                    'name' => $this->request->getVar('name'),
                    'description' => $this->request->getVar('desc'),
                ]);
                $project->where('IDproject',$IDproject);
                $project->update();

                return redirect()->to(base_url('/dasboard').'/'.$IDproject);
            }else{
                $this->session->setFlashdata('error', $validation->listErrors());
                return redirect()->to(base_url('/edit-project').'/'.$IDproject);
            }
        }

        $project = new Project_Mod();
        $project->select('IDproject,name,IDleader,description');
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();
        return view('usr/project-edit',$data);
    }

    public function add_post()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'post' => ['Project name' => 'post', 'rules' => 'required'],
        ]);
        $isValid = $validation->withRequest($this->request)->run();

        $IDpost = '';
        $cek = true;

        while($cek){
            $IDpost = uniqid();
            $cek = $this->cek_IDpost($IDpost);
        }

        $IDproject = $this->request->getVar('IDproject');
        if($isValid){
            $post = new Post_Mod();
            $post->insert([
                'IDpost' => $IDpost,
                'IDuser' => $this->session->IDuser,
                'IDproject' => $IDproject,
                'content' => $this->request->getVar('post'),
            ]);
        }

        return redirect()->to(base_url('/dasboard').'/'.$IDproject);
    }

    function cek_IDpost($IDpost)
    {
        $post = new Post_Mod();
        $temp['data'] = $post->where('IDpost',$IDpost)->findAll();
        if(count($temp['data']) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function task_list($IDproject)
    {
        $task = new Task_Mod();
        $project = new Project_Mod();
        $hist = new Task_Mod();

        $project->select('IDproject,name');
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();
        
        $hist->select('task.IDtask,taskhistory.time, user.name, taskhistory.activity');
        $hist->join('taskhistory','taskhistory.IDtask = task.IDtask');
        $hist->join('user','user.IDuser = taskhistory.IDuser');
        $hist->where('IDproject',$IDproject);
        $hist->orderBy('taskhistory.time','DESC');
        $hist->limit(1);
        $data['history'] = $hist->get()->getResult();

        $role = new Team_Mod();
        $role->select('role');
        $role->where('IDuser',$this->session->IDuser);
        $role->where('IDproject',$IDproject);
        $data['role'] = $role->first();

        $data['url'] = $this->uri->uri->getSegment(1);


        $data['task'] = $task->where('IDproject',$IDproject)->findAll();
        return view('usr/task_list',$data);
    }

    public function new_project()
    {
        $project = new Project_Mod();
        $team = new Team_Mod();
        $validation =  \Config\Services::validation();

        if (!empty($_POST)) {
            $validation->setRules([
                'name' => ['Project name' => 'name', 'rules' => 'required'],
            ]);
            $isValid = $validation->withRequest($this->request)->run();

            if ($isValid) {
                $cek = true;
                $IDproject = '';
                while ($cek) {
                    $IDproject = uniqid();
                    $cek = $this->cekIdProject($IDproject);
                }
                $project->insert([
                    "name" => $this->request->getVar('name'),
                    "IDleader" => $this->session->IDuser,
                    "IDproject" => $IDproject,
                    "description" => $this->request->getVar('description'),
                ]);
                $team->insert([
                    "IDproject" => $IDproject,
                    "IDuser" => $this->session->IDuser,
                    "role" => 'leader',
                ]);
                mkdir('upload/user_file/'.$IDproject,0777, true);
                return redirect()->to('/dasboard'.'/'.$IDproject);
            } else {
                $this->session->setFlashdata('error', $validation->listErrors());
                return view('usr/add-project');
            }
        }
        return view('usr/add-project');
    }

    public function cekIdProject($IDproject)
    {
        $project = new Project_Mod();
        $temp['data'] = $project->where('IDproject',$IDproject)->findAll();
        if(count($temp['data']) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function team($IDproject)
    {
        $inv = new Inv_Mod();
        $project = new Project_Mod();

        $project->select('IDproject,name');
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();

        $inv->select('user.name, invitation.IDinvite, invitation.IDuser');
        $inv->join('user','user.IDuser = invitation.IDuser');
        $inv->where('invitation.IDproject',$IDproject);
        $inv->where('status','waiting');
        $data['request'] = $inv->get()->getResult();

        $team = new Team_Mod();
        $team->select('user.name as uname,team.IDuser,user.username, team.role');
        $team->join('user','user.IDuser = team.IDuser');
        $team->where('team.IDproject',$IDproject);
        $team->orderBy('role','DESC');
        $data['team'] = $team->get()->getResult();

        $role = new Team_Mod();
        $role->select('role');
        $role->where('IDuser',$this->session->IDuser);
        $role->where('IDproject',$IDproject);
        $data['role'] = $role->first();

        $data['url'] = $this->uri->uri->getSegment(1);

        return view('usr/team_manage',$data);
    }

    public function update_role($role,$IDuser,$IDproject)
    {
        $team = new Team_Mod();
        $team->set([
            'role' => $role,
        ]);
        $team->where('IDproject',$IDproject);
        $team->where('IDuser',$IDuser);
        $team->update();

        return redirect()->to(base_url('/team').'/'.$IDproject);
    }

    public function delete_team($IDuser = null, $IDproject = null)
    {
        $team = new Team_Mod();
        $team->where('IDuser',$IDuser);
        $team->where('IDproject',$IDproject);
        $team->delete();

        return redirect()->to(base_url('team/'.$IDproject));
    }

    public function task_details($IDproject,$IDtask)
    {
        $task = new Task_Mod();
        $project = new Project_Mod();
        $submission = new Submission_Mod();

        $data['url'] = $this->uri->uri->getSegment(1);

        $project->select('IDproject,name');
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();

        $submission->select('IDsubmission,file');
        $submission->where('IDtask',$IDtask);
        $data['file'] = $submission->get()->getResult();

        $data['task'] = $task->where('IDtask',$IDtask)->first();
        
        $task = new Task_Mod();
        $task->select('taskhistory.description, time, activity, user.name');
        $task->join('taskhistory','taskhistory.IDtask = task.IDtask');
        $task->join('user','user.IDuser = taskhistory.IDuser');
        $task->where('task.IDtask',$IDtask);
        $task->orderBy('time','DESC');
        $task->limit(5);
        $data['taskHistory'] = $task->get()->getResult();

        $role = new Team_Mod();
        $role->select('role');
        $role->where('IDuser',$this->session->IDuser);
        $role->where('IDproject',$IDproject);
        $data['role'] = $role->first();

        return view('usr/task_details',$data);
    }

    public function update_task()
    {
        $task = new Task_Mod();
        $validation =  \Config\Services::validation();

        $data['url'] = $this->uri->uri->getSegment(1);

        $IDproject = $this->request->getVar('IDproject');
        $IDtask = $this->request->getVar('IDtask');
        $desc = $this->request->getVar('desc');
        $date = $this->request->getVar('date');
        $title = $this->request->getVar('title');

        $task->set([
            'description' => $desc,
            'dedline' => $date,
            'title' => $title,
        ]);
        $task->where('IDtask', $IDtask);
        $task->update();

        $history = new TaskHistory_Mod();
        $hist = [
            'IDtask' => $IDtask,
            'IDuser' => $this->session->IDuser,
            'activity' => 'update_desc',
        ];
        $history->insert($hist);

        return redirect()->to(base_url('task-details') . '/' . $IDproject . '/' . $IDtask);
    }

    public function join_page()
    {
        $project = new Project_Mod();
        $inv = new Inv_Mod();

        $inv->select('invitation.IDinvite, invitation.IDuser, invitation.IDproject, invitation.status, user.name as uname, project.name as pname');
        $inv->join('user','user.IDuser = invitation.IDuser');
        $inv->join('project','project.IDproject = invitation.IDproject');
        $inv->where('invitation.IDuser',$this->session->IDuser);
        $data['request'] = $inv->get()->getResult();

        $IDproject = $this->request->getPost('IDproject');
        $project->select('project.name as pname, u.name as uname, project.IDproject');
        $project->join('`user` as u','u.IDuser = project.IDleader');
        $project->where('IDproject',$IDproject);
        $data['search_result'] = $project->first();

        if(isset($IDproject)){
            if($data['search_result'] == null){
                $this->session->setFlashdata('nfn',$IDproject.' PROJECT ID NOT FOUND');
                return redirect()->route('join-team');
            }else{
                return view('usr/request-join',$data);
            }
        }else{
            return view('usr/request-join',$data);
        }
    }

    public function request_project($IDproject)
    {
        $inv = new Inv_Mod();

        $IDinvite = uniqid();

        $inv->select('IDproject');
        $inv->where('IDuser',$this->session->IDuser);
        $inv->where('IDproject',$IDproject);
        $user['user'] = $inv->first();

        if($user['user'] == null){
            $inv->insert([
                "IDinvite" => $IDinvite,
                "IDuser" => $this->session->IDuser,
                "IDproject" => $IDproject,
                "status" => 'waiting',
            ]);
            return redirect()->route('join-team');
        }else{
            $this->session->setFlashdata('nfn','Request already sent to join this project');
            return redirect()->route('join-team');
        }
    }

    public function cek_IDinvite($IDinvite)
    {
        $temp = null;
        $inv = new Inv_Mod();
        $temp['data'] = $inv->where('IDinvite',$IDinvite)->findAll();
        if(count($temp['data']) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function cancel_request($IDinvite)
    {
        $inv = new Inv_Mod();
        $inv->where('IDinvite',$IDinvite);
        $inv->delete();
        return redirect()->route('join-team');
    }

    public function accept_request($IDuser, $IDproject, $IDinvite)
    {
        $team = new Team_mod();   
        $team->insert([
            "IDproject" => $IDproject,
            "IDuser" => $IDuser,
            "role" => 'team',
        ]);

        $inv = new Inv_Mod();
        $inv->where('IDinvite',$IDinvite);
        $inv->delete();
        return redirect()->to(base_url('team/'.$IDproject));
    }

    public function reject_request($IDproject, $IDinvite)
    {
       $inv = new Inv_Mod();
       $inv->set('status','reject');
       $inv->where('IDinvite',$IDinvite);
       $inv->update();
       return redirect()->to(base_url('team/'.$IDproject));
    }

    public function new_task($IDproject)
    {
        $task = new Task_Mod();
        $project = new Project_Mod();
        $validation =  \Config\Services::validation();

        $IDproject = $IDproject;
        $project->where('IDproject',$IDproject);
        $data['project'] = $project->first();

        $data['url'] = $this->uri->uri->getSegment(1);

        if (!empty($_POST)) {
            $validation->setRules([
                'title' => ['Project title' => 'title', 'rules' => 'required'],
            ]);
            $isValid = $validation->withRequest($this->request)->run();

            if ($isValid) {
                $IDtask = '';
                $cek = true;
                while ($cek) {
                    $IDtask = uniqid();
                    $cek = $this->cek_IDtask($IDtask);
                }
                $task->insert([
                    "IDtask" => $IDtask,
                    "title" => $this->request->getPost('title'),
                    "description" => $this->request->getPost('description'),
                    "deadline" => $this->request->getPost('date'),
                    "status" => 'ongoing',
                    "IDproject" => $IDproject,
                ]);

                $history = new TaskHistory_Mod();
                $history->insert([
                    'IDtask' => $IDtask,
                    'IDuser' => $this->session->IDuser,
                    'activity' => 'create',
                    'description' => $this->request->getPost('title'),
                ]);
                
                return redirect()->to('/task-list'.'/'.$IDproject);
            } else {
                $this->session->setFlashdata('error', $validation->listErrors());
                return view('usr/add-task',$data);
            }
        }

        return view('usr/add-task',$data);
    }

    function cek_IDtask($IDtask)
    {
        $task = new Task_Mod();
        $task->select('IDtask');
        $temp['data'] = $task->where('IDtask',$IDtask)->findAll();
        if(count($temp['data']) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function file_upload()
    {
        $validation =  \Config\Services::validation();

        $rules = [
            'file' => 'mime_in[file,image/jpg,image/jpeg,image/png,application/pdf,application/doc,application/docx,application/ppt,application/pptx,application/zip,application/rar]|max_size[file,5210]',
        ];

        $messages = [
            'file' => [
                'mime_in' => 'Sorry, this file format does not supported to upload',
                'max_size' => 'Maximum files size is 5Mb',
            ],
        ];
        
        $validate = $this->validate($rules,$messages);

        $IDproject = $this->request->getVar('IDproject');
        $IDtask = $this->request->getVar('IDtask');

        if(!empty($_POST)){
            $validation->setRules([
                'file' => ['file' => 'file', 'rules' => 'required'],
            ]);

            if($validate)
            {
                $IDsubmission = '';
                $cek = true;
                while($cek)
                {
                    $IDsubmission = uniqid();
                    $cek = $this->cekID_submission($IDsubmission);
                }

                $file = $this->request->getFile('file');
                $file_name = $file->getClientName();
                $file_rename = $IDsubmission.'_'.$file->getClientName();
                $file->move('upload/user_file/'.$IDproject,$file_rename);

                $data = [
                    'file' => $file_rename,
                    'IDtask' => $this->request->getPost('IDtask'),
                    'IDsubmission' => $IDsubmission,
                ];

                $sub =  new Submission_Mod();
                $sub->insert($data);

                $history = new TaskHistory_Mod();
                $hist = [
                    'IDtask' => $IDtask,
                    'IDuser' => $this->session->IDuser,
                    'activity' => 'file',
                    'description' => $file_name,
                    'IDsubmission' => $IDsubmission,
                ];
                $history->insert($hist);
            }else{
                $this->session->setFlashdata('error', $validation->listErrors());
            }
        }

        return redirect()->to(base_url('/task-details').'/'.$IDproject.'/'.$IDtask);
    }

    function cekID_submission($IDsubmission)
    {
        $sub = new Submission_Mod();
        $sub->select('IDsubmission');
        $temp['data'] = $sub->where('IDsubmission',$IDsubmission)->findAll();
        if(count($temp['data']) > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    public function download_file($IDsubmission,$IDproject)
    {
        $sub = new Submission_Mod();
        $data = $sub->find($IDsubmission);

        return $this->response->download('upload/user_file/'.$IDproject.'/'.$data['file'],null);
    }

    public function delete_task($IDtask,$IDproject)
    {
        $this->delete_all_files_task($IDtask,$IDproject);
        $task = new Task_Mod();
        $task->where('IDtask',$IDtask);
        $task->delete();

        return redirect()->to(base_url('/task-list').'/'.$IDproject);
    }
    
    public function delete_all_files_task($IDtask,$IDproject)
    {
        $sub = new Submission_Mod();
        $data = $sub->where('IDtask',$IDtask)->findAll();

        $submission = new Submission_Mod();
        $submission->where('IDtask',$IDtask);
        $submission->delete();
        foreach($data as $data)
        {
            $files = './upload/user_file/'.$IDproject.'/'.$data['file'];
            unlink($files);
        }
        return;
    }

    public function delete_file($IDsubmission,$IDproject,$IDtask)
    {
        $sub = new Submission_Mod();
        $data = $sub->where('IDsubmission',$IDsubmission)->first();

        $file_name = $data['file'];
        $pos = strpos($file_name,'_');
        $length = strlen($file_name);
        $rename = substr($file_name,$pos+1,$length);
        $history = new TaskHistory_Mod();
        $hist = [
            'IDtask' => $IDtask,
            'IDuser' => $this->session->IDuser,
            'activity' => 'delete',
            'description' => $rename,
            'IDsubmission' => $IDsubmission,
        ];
        $history->insert($hist);

        $sub = new Submission_Mod();
        $sub->where('IDsubmission',$IDsubmission);
        $sub->delete();

        $files = './upload/user_file/'.$IDproject.'/'.$data['file'];
        unlink($files);

        return redirect()->to(base_url('/task-details').'/'.$IDproject.'/'.$IDtask);
    }

    public function delete_project($IDproject)
    {
        $task = new Task_Mod();
        $task->where('IDproject',$IDproject);
        $task->delete();

        $this->delete_directory($IDproject);

        $project = new Project_Mod();
        $project->where('IDproject',$IDproject);
        $project->delete();

        return redirect()->to(base_url('/project'));
    }
    
    function delete_directory($IDproject)
    {
        helper('filesystem');
        $path = './upload/user_file/'.$IDproject;
        delete_files($path);
        rmdir($path);

        return;
    }
}
