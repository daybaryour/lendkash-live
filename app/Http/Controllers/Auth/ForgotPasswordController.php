<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordValidation;
use App\Repositories\UserRepository;
use App\Http\Requests\ResetPasswordValidation;

class ForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     * return void
     */
    public function __construct(UserRepository $user) {
        $this->user = $user;
    }

    /**
     *
     * Send reset password link
     * @param object
     */
    public function sendResetLinkEmail(ForgotPasswordValidation $request) {
        try {
            //$this->validateEmail($request);
            if ($request->has('email')) {
                $checkEmail = findEmail($request->email, 'admin');
                if ($checkEmail) {
                    $saveToken = saveTokenLink($request->email);
                    $checkEmail['link'] = url('admin/password/reset/' . $saveToken);
                    $checkEmail['email'] = $request->email;
                    $checkEmail['name'] = $checkEmail['name'];
                    $checkEmail['subject'] = 'Forgot Password';
                    $emailSent = sendMails('emails.set-password', $checkEmail);
                    if ($emailSent) {
                        return json_encode(array('success' => 'true', 'message' =>__('auth.sent_email')));
                    } else {
                      return json_encode(array('success' => 'false', 'message' =>  __('auth.mail_not_sent')));
                    }
                } else {
                    return json_encode(array('success' => 'false', 'message' => __('auth.email_not_exist')));
                  //  return back()->withInput()->with('error_msg', __('auth.email_not_exist'));
                }
            }
        } catch (\Exception $e) {

            return json_encode(array('success' => 'false', 'message' => $e->getMessage()));
        }
    }

    /**
     * Reset password
     * @param object
     */
    public function reset(ResetPasswordValidation $request) {
        try {
            $checkToke = checkToken($request->token);
            if ($checkToke) {
                $changePassword = $this->user->updatePassword($request->all());
                if ($changePassword) {
                    if ($request->set_password) {
                        return redirect('login')->with('success_msg', __('auth.password_set'));
                    } else {
                        return redirect('admin/login')->with('success_msg', __('auth.password_set'));
                    }
                } else {
                    return back()->with('error_msg', __('auth.error_set_password'));
                }
            } else {
                return back()->with('error_msg', __('auth.session_expire'));
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

    /**
     * Set password view page
     * @param int
     */
    public function setPassword($token) {
        try {
            $users = checkToken($token);
            if ($users) {
                return view('emails.set-password', compact('users'));
            } else {
                return back()->with('error_msg', __("common.invalid_token"));
            }
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }

    /**
     * Validate the email for the given request
     * @param object
     */
    protected function validateEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email']);
    }

}
