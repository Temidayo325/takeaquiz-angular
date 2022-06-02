import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { UserService } from '../Services/user.service';

import {StoreService } from '../Services/store.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
     changeForm = this.fb.group({
          password: ['', [Validators.required, Validators.minLength(6)]],
          confirmPassword: ['', [Validators.required, Validators.minLength(6)]]
     });
  constructor(
       private router: Router,
       private toast: ToastService,
       private store: StoreService,
       private fb: FormBuilder,
       private userService: UserService
 ) {

}

     public user: any = this.store.getUser();
     public profile: boolean = false
     public sub: any
     public errors: any = []
     public togglePassword: boolean = false
     public type: string = 'password'
     public toggleConfirmPassword: boolean = false
     public type2: string = 'password'
     ngOnInit(): void {
       // this.router.navigate(['/'])
       if (this.store.token == null || this.store.token == '') {
            this.router.navigate(['/login'])
       }
  }
  logout()
  {

  }
  changePassword()
  {
       if (this.changeForm.value.password !== this.changeForm.value.confirmPassword) {
            this.errors.confirmPassword = "Your passwords do not match"
            console.log("not here")
       }else{
            console.log("definitely  not here")
            this.sub = this.userService.changeUserPassword({email: this.user.email, password1: this.changeForm.value.password, password2: this.changeForm.value.confirmPassword}).subscribe(
                 (res) => {
                      console.log(res)
                      if (res.data.statusCode === 200) {
                           this.errors = []
                           this.toast.success(res.data.message)
                           this.changeForm.patchValue({
                                password: '',
                                confirmPassword: ''
                           })
                      }
                 },
                 (err) => {
                      console.log(err)
                      alert(err.error.message)
                      this.errors = err.error.errors
                 }
            )
       }
  }
  showpassword()
  {
       this.togglePassword = !this.togglePassword
       if (this.type === 'password') {
            this.type = 'text'
       }else{
            this.type = 'password'
       }
  }
  showConfirmPassword()
  {
       this.toggleConfirmPassword = !this.toggleConfirmPassword
       if (this.type2 === 'password') {
          this.type2 = 'text'
       }else{
          this.type2 = 'password'
       }
  }
}
