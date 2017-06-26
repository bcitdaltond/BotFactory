<?php

class RegisterController extends Application
{
    /**
     * Index Page for RegisterController.
     *
     * Maps to the following URL
     *        http://example.com/
     *    - or -
     *        http://example.com/register
     *
     * map to /Manage/index
     */
    // not displayed on the menubar. The page will be rediredted to if the user needs to register.
    public function index()
    {
        $role = $this->session->userdata('userrole');

        $this->data['pagetitle'] = "Register";

        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role == ROLE_GUEST) redirect('/home');

        $this->session->userdata('message', null);
        
        $this->data['message'] = $this->session->userdata('message');

        $this->data['pagebody'] = 'Manage/register';

        $this->render();
    }

    /*
    * registers the user/account to get the token
    */
    public function register()
    {
        $password = $this->input->post('password');

        $response = "Error";

        // if the password field does not contain whitespace,
        if (!ctype_space($password)) {
            // writes the password to a password.txt file.
            $passwordFile = fopen("password.txt", "w+") or die("Unable to open file!");
            fwrite($passwordFile, $password);
            fclose($passwordFile);
            // retrievees the password from the text file and registers it
            $response = file_get_contents("https://umbrella.jlparry.com/work/registerme/apple/" . $password);
        }

        // split the return result from the server into $response array.
        $response = explode(" ", $response);

        // if the token is accepted (correct and valid)
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
        }  { // if the token is expired or incorrect password, will display error message and redirects to register page
            echo "The password or token is not valid. Please register again.";
            header( "refresh:5;url=/register" );
        }
    }
}