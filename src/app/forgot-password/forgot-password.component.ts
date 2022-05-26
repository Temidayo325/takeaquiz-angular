import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {

     recoveryForm = this.fb.group({
         email: ['', [Validators.required, Validators.email]]
     });
     public sub: any
  constructor(
       private fb : FormBuilder,
       private router: Router,
       private user: UserService,
 ) { }
  public errors: any  = []
  ngOnInit(): void {
  }
  recoverPassword()
  {
       this.sub = this.user.recoverEmail({email: this.recoveryForm.value.email}).subscribe(
            (res) => {
                 console.log(res)
                 if (res.data.statusCode == 202) {
                      alert(res.data.message)
                      localStorage.setItem('email', this.recoveryForm.value.email)
                      this.router.navigate(['/verify-password', { origin: 'recover' }])
                 }
            },

            (err) => {
                 console.log(err)
                 alert(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }
  login()
  {
       this.router.navigate(['/login'])
  }

  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
}
