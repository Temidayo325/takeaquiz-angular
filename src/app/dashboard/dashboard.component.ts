import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { UserService } from '../Services/user.service';
import { LoadingBarService } from '@ngx-loading-bar/core';
import {StoreService } from '../Services/store.service';
import { slideInRightAnimation, slideOutRightAnimation } from 'angular-animations';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
  animations: [
    // animation triggers go here
    slideInRightAnimation({duration: 2000}),
    slideOutRightAnimation()
  ]
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
       private userService: UserService,
       private loading: LoadingBarService,
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
       this.loading.start()
       if (this.store.token == null || this.store.token == '') {
            this.loading.complete()
            this.router.navigate(['/login'])
       }
       this.loading.complete()
  }
  logout()
  {
       if (confirm("Do you really want to logout?")) {
            this.store.logout()
            this.router.navigate(['/login'])
       }
  }
  changePassword()
  {
       this.loading.start()
       if (this.changeForm.value.password !== this.changeForm.value.confirmPassword) {
            this.errors.confirmPassword = "Your passwords do not match"
            this.loading.complete()
       }else{
            this.sub = this.userService.changeUserPassword({email: this.user.email, password1: this.changeForm.value.password, password2: this.changeForm.value.confirmPassword}).subscribe(
                 (res) => {
                      console.log(res)
                      if (res.data.statusCode === 200) {
                           this.errors = []
                           this.loading.complete()
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
                      this.loading.complete()
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
