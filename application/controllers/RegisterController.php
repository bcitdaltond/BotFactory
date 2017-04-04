<?php

class RegisterController extends Application
{
    public function index()
    {

        $role = $this->session->userdata('userrole');
        switch ($role) {
            case ROLE_GUEST:
                $this->data['menubuttons'] = '_buttonsguest';
                break;
            case ROLE_WORKER:
                $this->data['menubuttons'] = '_buttonsworker';
                break;
            case ROLE_SUPERVISOR:
                $this->data['menubuttons'] = '_buttonssupervisor';
                break;
            case ROLE_BOSS:
                $this->data['menubuttons'] = '_buttonsboss';
                break;
        }



        $this->data['pagetitle'] = "Register - BotFactory";
        $this->session->userdata('message', null);
        $this->data['message'] = $this->session->userdata('message');

        $this->data['pagebody'] = 'Manage/register';

        $this->render();
    }

    public function register()
    {
        $password = $this->input->post('password');

        $response = "Error";

        if (!ctype_space($password)) {
            $passwordFile = fopen("password.txt", "w+") or die("Unable to open file!");
            fwrite($passwordFile, $password);
            fclose($passwordFile);
            $response = file_get_contents("https://umbrella.jlparry.com/work/registerme/apple/" . $password);
        }

        $response = explode(" ", $response);

        if ($response[0] == "Ok") {

            //get the token and store it into database
            $token = $response[1];
            $db_token = $this->properties->create();
            $property = $this->properties->all();
            if(sizeof($property) == 0){
                $db_token->token = $token;
                $this->properties->add($db_token);
            }else{
                $update = array(
                    'id' => $property[0]->id,
                    'token' => $token
                );
                $this->properties->update($update);
            }

            $this->session->set_userdata('message', "Successfully Registered!");

            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');

        } else {
            echo "Get a real account";
//            $referred_from = $this->session->userdata('referred_from');
//            $this->session->set_userdata('message', "Oops: Bad password!");
//            redirect($referred_from, 'refresh');
        }
    }
}