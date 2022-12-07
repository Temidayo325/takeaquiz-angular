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
  selector: 'app-recover-password',
  templateUrl: './recover-password.component.html',
  styleUrls: ['./recover-password.component.css']
})
export class RecoverPasswordComponent implements OnInit {

  form = new FormGroup({
      "email": new FormControl("", [Validators.email, Validators.required, Validators.minLength(5)]),
  });
  constructor(
       private userService: UserService,
     // private storeService: StoreService,
     private loader: LoadingBarService,
     private router: Router,
     private route: ActivatedRoute,
     private toast: ToastService,
     private title: Title
  ) { }

  get email() { return this.form.get('email'); }
  error: any = []
  message: string = ''
  showLoader: boolean = false
  showSuccess: boolean = false
  successMessage: string = 'Verification email sent'

  ngOnInit(): void
  {
       this.title.setTitle("Recover your account")
  }

  onSubmit(): void
  {
       this.loader.start()
       this.showLoader = true
       let sub = this.userService.recoverEmail({email: this.form.value.email}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.showLoader = false
                 if (response.status) {
                      this.showSuccess = true
                      sessionStorage.setItem('email', this.form.value.email!)
                      setTimeout(() => {
                           this.showSuccess = false
                           this.router.navigate(['/change-password'])
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
