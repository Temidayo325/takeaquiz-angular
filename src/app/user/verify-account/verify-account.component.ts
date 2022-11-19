import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from './../../service/user.service';
import { StoreService } from './../../service/store.service';
import { Router, ActivatedRoute, ParamMap  } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-verify-account',
  templateUrl: './verify-account.component.html',
  styleUrls: ['./verify-account.component.css']
})
export class VerifyAccountComponent implements OnInit {

     form = new FormGroup({
            "code": new FormControl("", [Validators.required, Validators.minLength(5)]),
    });

  constructor(
       private userService: UserService,
     private storeService: StoreService,
     private loader: LoadingBarService,
     private router: Router,
     private route: ActivatedRoute,
     private toast: ToastService,
     private title: Title
 ) { }
  get code() { return this.form.get('code'); }
  error: any = []
  message: string = ''
  ngOnInit(): void
  {
       this.title.setTitle("Verify your Account")
  }

  onSubmit(): void
  {
       this.loader.start()
       this.userService.verifyAccount({email: sessionStorage.getItem('email'), code: this.form.value.code}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.toast.info(response.message)
                 if (response.status) {
                      this.router.navigate(['/login'])
                 }
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
