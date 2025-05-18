<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\WaitsForElements;
use Tests\DuskTestCase;
use function PHPUnit\Framework\assertSameSize;

class LandingPageTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function test_case_E1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('D A R A')
                ->assertSee('Digital Academic Repository and Archive')
                ;
        });
    }

    public function test_case_E2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('search', 'Academic')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->assertSee('Academic')
                ;
        });
    }

    public function test_case_E3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('from-year', '2023')
                ->type('to-year', '2025')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->assertSee('2024')
                ->assertSee('2025')
                ;
        });
    }

    public function test_case_E4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Login')
                ->assertPathIs('/go/login')
                
                ->assertSee('D A R A')
                ->assertSee('L O G I N')
                ;
        });
    }

    public function test_case_E5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('search', 'cisco')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->assertSee('Cisco')
                ;
        });
    }

    public function test_case_E6()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('search', 'cisco')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->type('search', 'academic')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                ->assertSee('Academic')
                ;
        });
    }

    public function test_case_E7()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('search', 'cisco')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->press('.help')
                ->assertPathIs('/')
                ->assertSee('D A R A')
                ->assertSee('Digital Academic Repository and Archive')
                ;
        });
    }

    public function test_case_E8()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('search', 'cisco')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                
                ->clickLink('Login')
                ->assertPathIs('/go/login')
                
                ->assertSee('D A R A')
                ->assertSee('L O G I N')
                ;
        });
    }

    public function test_case_E9()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '101010')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/admin')
                ->assertSee('Dashboard')
                
                ->press('button[class="lgt"]')
                ;
        });
    }

    public function test_incorrect_login_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '101010')
                ->type('password_hash_login', 'passworD2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/go/login')
                ->assertSee('Invalid credentials.')
                
                ;
        });
    }

    public function test_incorrect_login_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', 'incorrect')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/go/login')
                ->assertSee('Invalid credentials.')
                
                ;
        });
    }

    public function test_incorrect_login_3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '101010')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/admin')
                ->clickLink('Recovery')
                ->assertPathIs('/admin/recovery')
                ->pause(4000)
                ->press('button[class="lgt"]')
                ->assertPathIs('/go/login')
                ->type('usn_login', '19005')
                ->type('password_hash_login', 'password1')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/go/login')
                ->assertSee('Account suspended.')
                
                ;
        });
    }

    public function test_incorrect_login_4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '105” OR “1=1')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/go/login')
                ->assertSee('Invalid credentials.')
                
                ;
        });
    }

    public function test_click_forgot_password()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->clickLink('Forgot Password?')
                ->assertPathIs('/go/recovery')
                ->assertSee('Account Recovery')
                
                ;
        });
    }

    public function test_0_4_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/recovery')
                ->press('.help')
                ->assertPathIs('/')
                ->assertSee('D A R A')
                ->assertSee('Digital Academic Repository and Archive')
                
                ;
        });
    }

    public function test_0_4_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/recovery')
                ->type('search', 'Marc')
                ->press('button[type="submit"]')
                ->assertPathIs('/results')
                ->assertSee('Marc')
                
                ;
        });
    }

    public function test_0_4_3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/recovery')
                ->type('email', 'gambaza66@gmail.com')
                ->press('button[class="submit-btn"]')
                ->assertPathIs('/go/recovery/verify')
                ->assertSee('OTP Sent!')
                ->assertSee('gambaza66@gmail.com')
                
                ;
        });
    }

    public function test_0_4_4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/recovery')
                ->type('email', 'gambaza6@gmail.com')
                ->press('button[class="submit-btn"]')
                ->assertPathIs('/go/recovery')
                ->assertSee('gambaza6@gmail.com was not found in the system.')
                
                ;
        });
    }
    
    public function test_0_4_5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/recovery')
                ->type('email', 'email@email.com')
                ->press('button[class="submit-btn"]')
                ->assertPathIs('/go/recovery')
                ->assertSee('email@email.com was not found in the system.')
                
                ;
        });
    }
    
    // //*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*//

    public function test_1_1_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '101010')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/admin')
                ->assertSee('24')
                ->assertSee('Total User(s)')
                
                ;
        });
    }
    
    public function test_1_1_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->assertPathIs('/admin')
                ->assertSee('1')
                ->assertSee('Account(s) Suspended')
                
                ;
        });
    }
    
    public function test_1_1_3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->assertPathIs('/admin')
                ->assertSee('10.97 MB')
                ->assertSee('Total Space Used')
                
                ;
        });
    }
    
    public function test_1_1_5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->assertPathIs('/admin')
                ->assertSee('Abandoned')
                ->assertSee('Approved')
                ->assertSee('LostDoc')
                ->assertSee('Needs Revision')
                ->assertSee('Pending')
                ->assertSee('Rejected')
                ;
        });
    }
    
    public function test_1_1_7()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->assertPathIs('/admin')
                ->click('a[href="admin/user-control"].small-box-footer')
                ->assertPathIs('/admin/user-control')
                ->visit('/admin')
                ->click('a[href="admin/storage"].small-box-footer')
                ->assertPathIs('/admin/storage')
                ->visit('/admin')
                ->click('a[href="admin/recovery"].small-box-footer')
                ->assertPathIs('/admin/recovery')
                ->visit('/admin')
                ;
        });
    }
    
    public function test_1_1_8()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->press('button[class="lgt"]')
                ->assertPathIs('/go/login')
                ->assertSee('L O G I N')
                ;
        });
    }

    // //*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*//

    public function test_1_2_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->type('usn_login', '101010')
                ->type('password_hash_login', 'password2')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/admin')
                ->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->assertPresent('table thead th') 
                ->assertSeeIn('table thead', 'First Name')
                ->assertPresent('table tbody tr') 
                ->with('table tbody tr:first-child', function ($row) {
                    $row->assertSee('Analyn')  
                        ->assertSee('Gelicame') 
                        ->assertSee('teacher4@gmail.com')  
                        ->assertSee('Teacher')  
                        ->assertSee('Active')  
                        ->assertPresent('.edit-btn')
                        ->assertPresent('.delete-btn');
                });
        });
    }

    public function test_1_2_3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->type('search', 'Justin')
                ->press('button[class="atayaaa"]')
                ->assertSee('Justin')
                ;
        });
    }

    public function test_1_2_4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->press('button[class="adda"]')
                ->assertSee('Add New User')
                ;
        });
    }

    public function test_1_2_7()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->press('button[class="adda"]')
                ->type('first_name', 'test')
                ->type('last_name', 'test')
                ->type('usn', '122334')
                ->type('password_hash', 'P@ssw0rd1234')
                ->type('email', 'user#mail.com')
                ->press('button[name="addead"]')
                
                ;
        });
    }

    public function test_1_2_9()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->press('button[class="adda"]')
                ->type('first_name', 'Johnny')
                ->type('last_name', 'Dowwy')
                ->type('usn', '19028')
                ->type('password_hash', 'P@ss1234')
                ->type('email', 'john@example.com')
                ->press('button[name="addead"]')
                
                ;
        });
    }

    public function test_1_2_11()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->press('button[data-id="28"]')
                
                ;
        });
    }

    public function test_1_2_13()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->waitFor('button[data-id="28"]', 5)
                ->click('button[data-id="28"]')
                ->waitFor('#edit-user-form', 5)
                ->assertVisible('#edit-user-form')
                ->type('#edit-password', 'NewP@ss123')
                ->press('button[name="edita"]')
                
                ;
        });
    }

    public function test_1_2_14()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->waitFor('button[data-id="28"]', 5)
                ->click('button[data-id="28"]')
                ->waitFor('#edit-user-form', 5)
                ->assertVisible('#edit-user-form')
                ->type('#edit-email', 'abc@@com')
                ->press('button[name="edita"]')
                
                ;
        });
    }

    public function test_1_2_17()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/user-control')
                ->assertPathIs('/admin/user-control')
                ->waitFor('button[data-id="17"].delete-btn', 5)
                ->click('button[data-id="17"].delete-btn')
                ->waitFor('#delete-user-form', 5)
                ->assertVisible('#delete-user-form')
                ->press('button[id="confirm-delete"]')
                
                ;
        });
    }

    // //*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*//

    public function test_1_3_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/storage')
                ->assertPathIs('/admin/storage')
                ->type('search', 'Hello')
                ->press('button[class="atayaaa"]')
                ->assertSee('Hello')
                
                ;
        });
    }
    
    public function test_1_3_5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/storage')
                ->assertPathIs('/admin/storage')
                ->waitFor('button[data-id="50"]', 5)
                ->click('button[data-id="50"]')
                ->waitFor('#delete-user-form', 5)
                ->assertVisible('#delete-user-form')
                ->press('button[id="confirm-delete"]')
                ->waitFor('button[data-id="50"].recover', 5)
                ->click('button[data-id="50"].recover')
                ->waitFor('#delete-user-form', 5)
                ->assertVisible('#delete-user-form')
                ->press('button[id="confirm-delete"]')
                
                ;
        });
    }
    
    public function test_1_3_6()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/storage')
                ->assertPathIs('/admin/storage')
                ->waitFor('button[data-id="56"]', 5)
                ->click('button[data-id="56"]')
                ->waitFor('#delete-user-form', 5)
                ->assertVisible('#delete-user-form')
                ->press('button[id="confirm-delete"]')
                
                ;
        });
    }

    public function test_1_4_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')
                ->assertSee('Analyn')
                
                ;
        });
    }

    public function test_1_4_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')
                ->waitFor('button[data-id="17"]', 5)
                ->press('button[data-id="17"]')
                ->waitFor('#recover-user-form', 5)
                ->assertVisible('#recover-user-form')
                ->assertSee('Recover this account?')
                ->assertSee('Are you sure you want to recover this user?')
                ->press('button[id="confirm-recover"]')
                
                ;
        });
    }

    public function test_1_4_3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')
                ->press('button[data-role="Admin"]')
                
                ->press('button[data-role="Teacher"]')
                
                ->press('button[data-role="Student"]')
                
                ->press('button[data-role="all"]')
                
                ;
        });
    }

    public function test_1_4_4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')
                ->type('#search-bar', 'rac')
                ->assertSee('Race')
                ;
        });
    }

    public function test_1_4_5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')

                ->click('a[href="/admin"]')
                ->assertPathIs('/admin')

                ->click('a[href="admin/recovery"].unq')
                ->assertPathIs('/admin/recovery')

                ->click('a[href="user-control"]')
                ->assertPathIs('/admin/user-control')

                ->click('a[href="recovery"]')
                ->assertPathIs('/admin/recovery')

                ->click('a[href="/admin/storage"]')
                ->assertPathIs('/admin/storage')

                ->click('a[href="recovery"]')
                ->assertPathIs('/admin/recovery')

                ->click('a[href="edit"]')
                ->assertPathIs('/admin/edit')

                ->click('a[href="recovery"]')
                ->assertPathIs('/admin/recovery')

                
                ;
        });
    }

    public function test_1_4_6()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/recovery')
                ->assertPathIs('/admin/recovery')
                ->press('button[class="lgt"]')
                
                ;
        });
    }

    // //*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*//

    public function test_2_1_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->assertPathIs('/go/login')
                ->type('usn_login', '19001')
                ->type('password_hash_login', 'password1')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/student')
                ->assertSee('Welcome')
                ->click('a[href="student/document-submission"]')
                ->assertSee('SUBMIT A DOCUMENT')

                ->assertVisible('#documentForm')

                ->press('button[id="submitButton"]')
                
                ;
        });
    }

    public function test_2_2_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/student/document-status')
                ->assertPathIs('/student/document-status')
                ->assertSee('Not yet read by Gelicame')
                ;
        });
    }

    public function test_2_2_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/student/document-status')
                ->assertPathIs('/student/document-status')
                ->clickLink('Poem')
                ->assertPathIs('/student/pdf-reader/67')
                ->pause(2000)
                ->assertSee('Poem')
                
                ->press('button[class="lgt"]')
                ;
        });
    }

    // //*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*//

    public function test_3_1_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/go/login')
                ->assertPathIs('/go/login')
                ->type('usn_login', '10004')
                ->type('password_hash_login', 'password1')
                ->press('button[name="submitlogin"]')
                ->assertPathIs('/teacher')
                ->assertSee('Welcome')
                ->click('a[href="teacher/review-studies"]')
                ->assertSee('Pending')
                
                ;
        });
    }

    public function test_3_1_2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/teacher/review-studies')
                ->assertPathIs('/teacher/review-studies')
                ->waitForText('Placeholder or dummy text', 10) 
                ->clickLink('Placeholder or dummy text')
                ->press('button[id="approveBtn"]')
                ->pause(1000)
                ->press('button[type="submit"].confirm') // Corrected selector
                ->assertSee('Approved')
                
                ;
        });
    }

    public function test_4_1_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/teacher/edit')
                ->assertPathIs('/teacher/edit')
                ->assertPathIs('/teacher/edit')
                ->assertSee('VERIFY YOUR IDENTITY')
                ->assertSee('Enter your password:')
                ->type('password_hash', 'password1')
                ->press('button[class="kapoya"]')
                ->waitFor('#edit-account-form', 5)
                ->assertVisible('#edit-account-form')
                ->type('last_name', 'Pelonio')
                ->press('button[class="sab"]')
                ->assertSee('Nice')
                
                ;
        });
    }
}
