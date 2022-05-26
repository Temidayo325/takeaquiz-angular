import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
     loginForm = this.fb.group({
         email: ['', [Validators.required, Validators.email]],
         password: ['', [Validators.required, Validators.minLength(9)]]
     });
     registerForm = this.fb.group({
          name: ['', [Validators.required, Validators.minLength(6)]],
          email: ['', [Validators.required, Validators.email]],
          institution: ['', [Validators.required, Validators.minLength(3)]],
          password: ['', [Validators.required, Validators.minLength(6)]],
          confirmPassword: ['', [Validators.required, Validators.minLength(6)]]
     });
     public registered: boolean = true
     public title: string = "Login to takeaquiz"
     public errors: any = []
     public type: string = 'password'
     public type2: string = 'password'
     public togglePassword: boolean = true
     public toggleConfirmPassword: boolean = true
     public background = 'register'
     public sub: any
  constructor(
       private fb : FormBuilder,
       private router: Router,
       private user: UserService,
 ) { }

  ngOnInit(): void {
  }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
     login()
     {
          this.sub = this.user.login({email: this.loginForm.value.email, password: this.loginForm.value.password}).subscribe(
               (res) => {
                    console.log(res)
                    if (res.data.statusCode == 200) {
                         alert(res.data.message)
                         this.router.navigate(['/dashboard'])
                    }
                    if (res.data.statusCode >= 400) {
                         alert(res.data.message)
                    }
               },
               (err) => {
                    console.log(err)
                    this.errors = err.error.errors
                    alert("there was an error")
               }
          )
     }
     registerUser()
     {
          if (this.registerForm.value.password !== this.registerForm.value.confirmPassword) {
               this.errors.confirmPassword = "Your passwords do not match"
          }else{
               let user =
               {
                    email: this.registerForm.value.email,
                    name: this.registerForm.value.name,
                    institution: this.registerForm.value.institution,
                    password: this.registerForm.value.password
               }
               this.user.register(user).subscribe(
                    (res) => {
                         console.log(res)
                         localStorage.setItem('email', user.email)
                         this.router.navigate(['/verify-password', { origin: 'register' }])
                    },
                    (err) => {
                         this.errors = err.error.errors
                         console.log(this.errors)
                    }
               )
          }
     }
     switchForm()
     {
          this.registered = !this.registered;
          // this.background == 'register' ? 'login': 'register';
          if (this.background === 'login') {
               this.background = 'register'
          }else{
               this.background = 'login'
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
          // (this.background == 'login') ? 'register': 'login';
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
     forgotPassword()
     {
          this.router.navigate(['/forgot-password'])
     }
}
