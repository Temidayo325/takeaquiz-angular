import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { UserService } from '../service/user.service';
import { StoreService } from '../service/store.service';
import { Router } from '@angular/router';
import { Login } from './../models/login.models';
import {Title} from '@angular/platform-browser';
@Component({
  selector: 'app-admin-login',
  templateUrl: './admin-login.component.html',
  styleUrls: ['./admin-login.component.css']
})
export class AdminLoginComponent implements OnInit {

     form = new FormGroup({
            "email": new FormControl("", [Validators.required, Validators.email]),
            "password": new FormControl("", [Validators.required, Validators.minLength(5)]),
    });
    public error: any = []
  constructor(
       private userService: UserService,
       private storeService: StoreService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private title: Title
 ) {
      this.title.setTitle("Login to your admin dashboard")
   }

  ngOnInit(): void {
  }
  onSubmit()
  {
       this.loader.start()
       this.userService.adminLogin({email: this.form.value.email!, password: this.form.value.password!}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.toast.success(response.message)
                 this.storeService.setuser(response.user, response.token)
                 this.storeService.setAdmin(response.questions, response.topics)
                 this.router.navigate(['/admin/dashboard'])
            },

            (error) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }
}
