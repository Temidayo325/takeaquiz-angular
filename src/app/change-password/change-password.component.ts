import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.scss']
})
export class ChangePasswordComponent implements OnInit {
     changeForm = this.fb.group({
          password: ['', [Validators.required, Validators.minLength(6)]],
          confirmPassword: ['', [Validators.required, Validators.minLength(6)]]
     });
  constructor(
       private fb : FormBuilder,
       private router: Router,
       private user: UserService,
 ) { }
     public errors: any = []
     public togglePassword: boolean = true
     public type: string = 'password'
     public type2: string = 'password'
     public toggleConfirmPassword: boolean = true
     public sub: any
  ngOnInit(): void {
  }
  changePassword()
  {
       if (this.changeForm.value.password !== this.changeForm.value.confirmPassword) {
            this.errors.confirmPassword = "Your passwords do not match"
            console.log("not here")
       }else{
            console.log("definitely  not here")
            this.sub = this.user.changeUserPassword({email: localStorage.getItem('email'), password1: this.changeForm.value.password, password2: this.changeForm.value.confirmPassword}).subscribe(
                 (res) => {
                      console.log(res)
                      if (res.data.statusCode === 200) {
                           this.errors = []
                           alert(res.data.message)
                           localStorage.clear()
                           this.router.navigate(['/login'])
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
