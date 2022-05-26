import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

@Component({
  selector: 'app-verify-password',
  templateUrl: './verify-password.component.html',
  styleUrls: ['./verify-password.component.scss']
})
export class VerifyPasswordComponent implements OnInit {

     verificationForm = this.fb.group({
         code: ['', [Validators.required, Validators.minLength(6)]]
     });
     public sub: any
     public errors: any = []
     public origin: any;
  constructor(
       private fb : FormBuilder,
       private router: Router,
       private user: UserService,
       private route: ActivatedRoute,
 ) { }

  ngOnInit(): void {
       this.origin = this.route.snapshot.paramMap.get('origin');
  }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
  verifyCode()
  {
       this.sub = this.user.verifyAccount({email: localStorage.getItem('email'), code: this.verificationForm.value.code}).subscribe(
            (res) => {
                 console.log(res.data)
                 if (res.data.statusCode === 202) {
                      if (this.origin == 'recover') {
                         alert("Account retrieved succesfully")
                         this.router.navigate(['/change-password'])
                      }

                      if (this.origin == 'register') {
                           alert(res.data.message)
                           localStorage.clear()
                           this.router.navigate(['/login'])
                      }

                 }

                 if (res.data.statusCode >= 400) {
                      alert(res.data.message)
                 }
            },
            (error) => {
                 console.log(error)
                 alert(error.error.message)
                 this.errors = error.error.errors
            }
       )
  }
  resendVerification()
  {

  }
}
