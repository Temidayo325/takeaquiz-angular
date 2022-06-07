import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { PrepService } from '../Services/prep.service';

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

  constructor(
       private fb : FormBuilder,
       private router: Router,
       private toast: ToastService,
       private prep: PrepService
 ) { }
     public sub: any
     public errors: any = []
  ngOnInit(): void
  {

  }
  preQuestion()
  {
       this.sub = this.prep.get(this.prepForm.value.display_token, this.prepForm.value.matric).subscribe(
            (res) => {
                 console.log(res)
                 if (res.data != undefined) {
                      this.toast.error(res.data.message)
                 }else{
                      this.toast.info(res.message)
                      this.prep.store(res.questions)
                      this.router.navigate(['/quiz'])
                 }
            },
            (err) => {
                 console.log(err)
                 this.toast.warn(err.error.message)
            }
       )
  }
  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       this.sub.unsubscribe()
  }
}
