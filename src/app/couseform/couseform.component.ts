import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { CourseService } from '../Services/course.service';
import { ToastService } from 'angular-toastify';
import { LoadingBarService } from '@ngx-loading-bar/core';

@Component({
  selector: 'app-couseform',
  templateUrl: './couseform.component.html',
  styleUrls: ['./couseform.component.scss']
})
export class CouseformComponent implements OnInit {
  courseForm = this.fb.group({
         course: ['', [Validators.required, Validators.minLength(3)]],
         type: ['', [Validators.required, Validators.minLength(3)]]
  });
  @Output() addedCourseEvent = new EventEmitter<boolean>();

  constructor(
       private fb: FormBuilder,
       private course: CourseService,
       private toast: ToastService,
       private loading: LoadingBarService,
 ) { }

     public sub: any
     public errors: any
  ngOnInit(): void
  {
  }
  createForm()
  {
       this.loading.start()
       this.sub = this.course.create({...this.courseForm.value}).subscribe(
            (res) => {
                 this.loading.complete()
                 this.toast.success(res.message)
                 this.addedCourseEvent.emit(true)
                 // emit a change up to ensure this corrections are made
            },
            (err) => {
                 console.log(err)
                 this.loading.complete()
                 this.errors = err.error.errors
                 this.toast.warn(err.error.message)
            }
       )
  }
}
