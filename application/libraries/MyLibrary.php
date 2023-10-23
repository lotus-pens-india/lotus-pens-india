<?php
class MyLibrary
{
    public function sendMail()
    {

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'your-smtp-server.com',
            'smtp_port' => 587,
            'smtp_user' => 'your-email@example.com',
            'smtp_pass' => 'your-email-password',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->email->initialize($config);
        $this->email->from('admin@lotuspens.com', 'Lotus Pens');
        $this->email->to('akshaywaghe2611@gmail.com');
        $this->email->subject('Order Received');
        $this->email->message('Your order received syccessfully');

        if ($this->email->send()) {
            echo 'Email sent successfully!';
        } else {
            echo 'Email could not be sent.';
            echo $this->email->print_debugger();
        }
    }
}
