import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from '../service/user.service';
import { StoreService } from '../service/store.service';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { NewUser } from './../models/newUser.models';
import { LoaderComponent } from './../components/loader/loader.component';
import { SuccessComponent } from './../components/success/success.component';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

     form = new FormGroup({
          "email": new FormControl("", [Validators.required, Validators.email]),
          "name": new FormControl("", [Validators.required, Validators.minLength(5)]),
          "nickname": new FormControl("", [Validators.required,Validators.minLength(4)]),
          "institution": new FormControl("", [Validators.required, Validators.minLength(3)]),
          "is_proffessional": new FormControl(localStorage.getItem("isProffessional"), [Validators.required]),
          "password": new FormControl("", [Validators.required, Validators.minLength(5)]),
    });

  constructor(
       private userService: UserService,
     private storeService: StoreService,
     private loader: LoadingBarService,
     private router: Router,
     private toast: ToastService,
     private title: Title
 ) {
      this.title.setTitle('Create an account with us')
 }

      get name() { return this.form.get('name'); }
      get nickname() { return this.form.get('nickname'); }
      get institution() { return this.form.get('institution'); }
      get password() { return this.form.get('password'); }
      get email() { return this.form.get('email'); }

      error: any = []
      message: string = ''
      showLoader: boolean = false
      assessment_status: string = localStorage.getItem("isProffessional")!
      showSuccess: boolean = false
  ngOnInit(): void
  {
       // if(localStorage.getItem("isProffessional") == "proffesional")
       // {
       //      this.toast.info("Kindly note that we only have PeP exam mock assessments. If you require more than, reach out to us via our contact page and we'll be happy to get you started on your desired mock assesment");
       // }
  }

  onSubmit()
  {
        // this.showLoader = true
       this.loader.start()
       this.showLoader = true
       let proffesional = this.form.value.is_proffessional == 'student' ? false : true
       let user: NewUser = {email: this.form.value.email!, password: this.form.value.password!, nickname: this.form.value.nickname!, institution: this.form.value.institution!, name: this.form.value.name!, is_proffessional: proffesional}
      this.userService.register(user).subscribe(
           (response) => {
                this.loader.complete()
                if (response.status != false) {
                     this.storeService.setuser(response.user, response.token)
                     this.storeService.setTopicAndResult(response.topics, response.results)
                     sessionStorage.setItem('email', this.form.value.email!)
                     this.form.reset()
                     this.showLoader = false
                     this.showSuccess = true
                     setTimeout(() => {
                          this.showSuccess = false
                          this.router.navigate(['/login'])
                     }, 2000)
                }
                this.message = response.message
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
