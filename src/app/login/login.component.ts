import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from '../service/user.service';
import { StoreService } from '../service/store.service';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
     form = new FormGroup({
            "email": new FormControl("", [Validators.required, Validators.email]),
            "password": new FormControl("", [Validators.required, Validators.minLength(5)]),
    });

  constructor(
       private userService: UserService,
       private storeService: StoreService,
       private loader: LoadingBarService,
       private router: Router,
       private toast: ToastService
 ) { }

  public error: any = []
  public message: string = ''
  ngOnInit(): void {
  }

  onSubmit()
  {
       this.loader.start()
      this.userService.login({email: this.form.value.email!, password: this.form.value.password!}).subscribe(
           (response) => {
                this.loader.complete()
                if (response.status != false) {
                     this.toast.success(response.message)
                     this.storeService.setuser(response.user, response.token)
                     this.storeService.setTopicAndResult(response.topics, response.results)
                     this.router.navigate(['/user/dashboard'])
                }
                this.toast.success(response.message)
                this.message = response.message
           },

           (error) => {
                this.loader.complete()
                console.log(error)
                this.toast.warn(error.error.message)
                this.error = error.error.errors
           }
      )
  }
}
