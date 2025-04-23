import { Component, OnInit } from '@angular/core';
import { ToastService } from 'angular-toastify';
import { Title } from '@angular/platform-browser';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { trigger, transition, state, style, animate } from '@angular/animations';
import { HotToastService } from '@ngneat/hot-toast';

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.scss'],
  animations: [
       trigger('showHide', [
            state('show', style({
                   transform: 'translateY(0)',
             })),
             state('hide', style({
                   transform: 'translateY(1000%)',
             })),
             transition("show <=> hide", animate("1000ms ease-in-out"))
      ])
 ]
})
export class LandingPageComponent implements OnInit {

     registerForm = this.fb.group({
          name: ['', [Validators.required, Validators.minLength(6)]],
          email: ['', [Validators.required, Validators.email]],
          institution: ['', [Validators.required, Validators.minLength(3)]]
     });

     public title: string = "Join our waitlist"
     public errors: any = []
     public sub: any
     public signUpSuccessful: boolean = false

  constructor(
       private fb : FormBuilder,
       private user: UserService,
       private toast: ToastService,
       private titleservice : Title,
       private testToast: HotToastService,
       private loading : LoadingBarService
 ) { }

  ngOnInit(): void
  {
       this.titleservice.setTitle(this.title)
  }

  ngOnDestroy(): void
  {
       if (this.sub !== undefined  ) {
            this.sub.unsubscribe()
       }
  }

  registerUser()
  {
       this.loading.start()
       this.registerForm.disable()
       const loadingToast = this.testToast.loading("preparing your Information")
       let user =
       {
            email: this.registerForm.value.email,
            name: this.registerForm.value.name,
            institution: this.registerForm.value.institution,
            origin: "landing-page"
       }
       setTimeout( () => {
            loadingToast.updateMessage("Adding you to our list")
       }, 1000)
       this.user.register(user).subscribe(
            (res) => {
                 this.signUpSuccessful = true
                 this.loading.complete()
                 loadingToast.close()
                 this.testToast.success("Your spot has been succesfully secured")
                 setTimeout(() => {
                    this.signUpSuccessful = false
                    this.registerForm.enable()
                    this.registerForm.reset()
                 }, 5000);
            },
            (err) => {
               console.log(err)
                 this.errors = err.error.errors
                 this.loading.complete()
                 this.registerForm.enable()
                 loadingToast.close()
                 this.testToast.error(err.error.message)
            }
       )
  }

  gotoform($event: any)
  {
     console.log($event)
  }
}
