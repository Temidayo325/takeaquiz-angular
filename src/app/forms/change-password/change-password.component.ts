import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from './../../service/user.service';
import { Router, ActivatedRoute, ParamMap  } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { LoaderComponent } from './../../components/loader/loader.component';
import { SuccessComponent } from './../../components/success/success.component';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.css']
})
export class ChangePasswordComponent implements OnInit {

     form = new FormGroup({
          "password": new FormControl("", [Validators.required, Validators.minLength(6)]),
         "confirmPassword": new FormControl("", [Validators.required, Validators.minLength(6)]),
     });

  constructor(
        private userService: UserService,
        private loader: LoadingBarService,
        private router: Router,
        private route: ActivatedRoute,
        private toast: ToastService,
        private title: Title
  ) { }

  get password() { return this.form.get('password'); }
  get confirmPassword() { return this.form.get('confirmPassword'); }

  error: any = []
  message: string = ''
  showLoader: boolean = false
  showSuccess: boolean = false
  successMessage: string = 'Password reset successful'

  ngOnInit(): void
  {
       this.title.setTitle("Reset your password")

  }

  onSubmit(): void
  {
       this.loader.start()
       this.showLoader = true
       let sub = this.userService.changeUserPassword({email: sessionStorage.getItem('email')!, password: this.form.value.password}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.showLoader = false
                 if (response.status) {
                     this.showSuccess = true
                     this.form.reset()
                     setTimeout(() => {
                          this.showSuccess = false
                          this.router.navigate(['/login'])
                     }, 2000)
                 }
            },
            (error) => {
                 this.loader.complete()
                 this.showLoader = false
                this.toast.warn(error.error.message)
                this.error = error.error.errors
            }
       )
  }
}
