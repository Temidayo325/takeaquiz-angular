import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { HotToastService } from '@ngneat/hot-toast';
import { PrepService } from '../Services/prep.service';
import { Title } from '@angular/platform-browser';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { Drawer } from 'flowbite';
import type { DrawerOptions, DrawerInterface } from 'flowbite';
import type { InstanceOptions } from 'flowbite';

@Component({
  selector: 'app-prep',
  templateUrl: './prep.component.html',
  styleUrls: ['./prep.component.scss']
})
export class PrepComponent implements OnInit {

     prepForm = this.fb.group({
          display_token: ['', [Validators.required, Validators.minLength(6)]],
          matric: ['', [Validators.required, Validators.minLength(6)]],
          email: ['', [Validators.required, Validators.minLength(6)]],
          assesment_id: ['1',  [Validators.required, Validators.minLength(1)]]
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
       private loading: LoadingBarService,
       private hotToast: HotToastService,
 ) { }
     public sub: any
     public errors: any = []
     public complaint: boolean = false
     public rules: boolean = false

  ngOnInit(): void
  {
        this.title.setTitle("Take a test || Student test login");
  }

  preQuestion():void
  {
       this.loading.start()
       const loadingToast = this.hotToast.loading("Loading and prepping assessment")
       this.sub = this.prep.get(this.prepForm.value.display_token, this.prepForm.value.matric, this.prepForm.value.assesment_id, this.prepForm.value.email).subscribe(
            (res) => {
                 this.loading.complete()
                 if (res.data != undefined) {
                      loadingToast.close()
                      this.hotToast.error(res.data.message)
                      // this.toast.error(res.data.message)
                 }else{
                      // this.toast.info(res.message)
                      loadingToast.close()
                      this.hotToast.info(res.message)
                      this.prep.store(res.questions, parseInt(res.course.duration), this.prepForm.value.display_token, this.prepForm.value.matric, res.course.type, parseInt(this.prepForm.value.assesment_id))
                      sessionStorage.setItem("email", res.student.email)
                      sessionStorage.setItem("assessment_topic", res.course.topic)
                      this.router.navigate(['/quiz'])
                 }
            },
            (err) => {
                 this.loading.complete()
                 // this.toast.warn(err.error.message)
                 loadingToast.close()
                 this.hotToast.warning(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }

  sendComplaint():void
  {
       this.loading.start()
       const loadingToast = this.hotToast.loading("Sending your complaints to the author of the assessment")
       this.sub = this.prep.postComplaint(this.complaintForm.value).subscribe(
            (res) => {
                 this.loading.complete()
                 loadingToast.close()
                 this.hotToast.success(res.message)
                // this.toast.info(res.message)
                this.complaintForm.reset()
                this.closeSidebar()
            },
            (err) => {
                 this.loading.complete()
                 loadingToast.close()
                 this.hotToast.error(err.error.message)
                 // this.toast.warn(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }

  public sideBarInterface():DrawerInterface
  {
       const $targetEl: HTMLElement = document.getElementById("drawer-right-example")!;
       const options: DrawerOptions = {
           placement: 'right',
           backdrop: true,
           bodyScrolling: false,
           edge: false,
           edgeOffset: ''
       };
       const instanceOptions: InstanceOptions = {
       id: 'drawer-right-example',
       override: true
       };
       const drawer: DrawerInterface = new Drawer($targetEl, options, instanceOptions);
       return drawer;
  }

  public closeSidebar()
  {
       const sideBar = this.sideBarInterface()
       sideBar.hide()
  }

  lodgeComplaint(direction: string)
  {
      if(direction == "lodge")
      {
           this.complaint = true
      }else{
           this.rules = true
      }
      const sideBar = this.sideBarInterface()
      sideBar.show()
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
