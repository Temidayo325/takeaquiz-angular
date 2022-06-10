import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { Router } from '@angular/router';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { Title } from '@angular/platform-browser';

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
       private loading: LoadingBarService,
       private toast: ToastService,
       private title: Title,
 ) { }
  public errors: any  = []
  ngOnInit(): void {
       this.title.setTitle("Recover your password")
  }
  recoverPassword()
  {
       this.loading.start()
       this.sub = this.user.recoverEmail({email: this.recoveryForm.value.email}).subscribe(
            (res) => {
                 this.loading.complete()
                 if (res.data.statusCode == 202) {
                      this.toast.info(res.data.message)
                      localStorage.setItem('email', this.recoveryForm.value.email)
                      this.router.navigate(['/verify-password', { origin: 'recover' }])
                 }
            },

            (err) => {
                 this.loading.complete
                 this.toast.warn(err.error.message)
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
       if (this.sub !== undefined) {
            this.sub.unsubscribe()
       }
  }
}
