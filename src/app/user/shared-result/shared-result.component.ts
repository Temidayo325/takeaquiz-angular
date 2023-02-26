import { Component, OnInit } from '@angular/core';
import { RouterModule, Routes, ActivatedRoute, Router } from '@angular/router';
import { AssesmentService } from './../../service/assesment.service';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { LoaderComponent } from './../../components/loader/loader.component';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-shared-result',
  templateUrl: './shared-result.component.html',
  styleUrls: ['./shared-result.component.css']
})
export class SharedResultComponent implements OnInit {

  constructor(
      private route: ActivatedRoute,
      private router: Router,
      private assesment: AssesmentService,
      private loader: LoadingBarService,
      private toast: ToastService,
      private title: Title
 ) {
      this.title.setTitle("View shared result")
 }
     result: any;
     showLoader: boolean = true
  ngOnInit(): void
  {
       this.loader.start()
      const code: string = this.route.snapshot.paramMap.get('code')!
      this.assesment.GetSharedAssessmentResult(code).subscribe(
           (response: any) => {
                this.result = response.data
                this.loader.complete()
                this.showLoader = false
           },
           (error) => {
                this.toast.error("sUnable to retrieve assessment result")
                this.loader.complete()
                this.showLoader = false
           }
      )
  }

  signup()
  {
      this.router.navigate(['/login'])
  }

}
