import { Component, OnInit } from '@angular/core';
import { ToastService } from 'angular-toastify';
import { Title } from '@angular/platform-browser';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../Services/user.service';
import { trigger, transition, state, style, animate } from '@angular/animations';

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

       let user =
       {
            email: this.registerForm.value.email,
            name: this.registerForm.value.name,
            institution: this.registerForm.value.institution,
            origin: "landing-page"
       }
       this.user.register(user).subscribe(
            (res) => {
                 this.toast.success("You have been succesfully added to our waitlist.")
                 this.signUpSuccessful = true
                 this.loading.complete()
                 setTimeout(() => {
                    this.signUpSuccessful = false
                    this.registerForm.enable()
                    this.registerForm.reset()
                 }, 5000);
            },
            (err) => {
                 this.errors = err.error.errors
                 this.loading.complete()
                 this.registerForm.enable()
                 this.toast.error(err.error.message)
            }
       )
  }

  gotoform($event: any)
  {
     console.log($event)
  }
}
