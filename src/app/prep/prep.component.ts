import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { PrepService } from '../Services/prep.service';
import { Title } from '@angular/platform-browser';
import { LoadingBarService } from '@ngx-loading-bar/core';

@Component({
  selector: 'app-prep',
  templateUrl: './prep.component.html',
  styleUrls: ['./prep.component.scss']
})
export class PrepComponent implements OnInit {

     prepForm = this.fb.group({
          display_token: ['', [Validators.required, Validators.minLength(6)]],
          matric: ['', [Validators.required, Validators.minLength(6)]]
     });
     complaintForm = this.fb.group({
          complaint: ['', [Validators.required, Validators.minLength(6)]],
          matric: ['', [Validators.required, Validators.minLength(6)]],
          display_token: ['', [Validators.required, Validators.minLength(5)]],
          email: ['', [Validators.required, Validators.email]]
     });

  constructor(
       private fb : FormBuilder,
       private router: Router,
       private toast: ToastService,
       private prep: PrepService,
       private title : Title,
       private loading: LoadingBarService
 ) { }
     public sub: any
     public errors: any = []
     public complaint: boolean = false
  ngOnInit(): void
  {
        this.title.setTitle("Take a test || Student test login");
  }
  preQuestion():void
  {
       this.loading.start()
       this.sub = this.prep.get(this.prepForm.value.display_token, this.prepForm.value.matric).subscribe(
            (res) => {
                 this.loading.complete()
                 if (res.data != undefined) {
                      this.toast.error(res.data.message)
                 }else{
                      this.toast.info(res.message)
                      this.prep.store(res.questions, parseInt(res.time), this.prepForm.value.display_token, this.prepForm.value.matric, res.type)
                      this.router.navigate(['/quiz'])
                 }
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }
  sendComplaint():void
  {
       this.loading.start()
       this.sub = this.prep.postComplaint(this.complaintForm.value).subscribe(
            (res) => {
                 this.loading.complete()
                this.toast.info(res.message)
                this.complaintForm.reset()
                this.complaint = !this.complaint
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }
  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.sub != undefined) {
            this.sub.unsubscribe()
       }
  }
}
