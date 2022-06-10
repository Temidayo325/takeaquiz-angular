import { Component, OnInit } from '@angular/core';
import { ComplaintService } from '../Services/complaint.service';
import { ToastService } from 'angular-toastify';
import { LoadingBarService } from '@ngx-loading-bar/core';

@Component({
  selector: 'app-complaints',
  templateUrl: './complaints.component.html',
  styleUrls: ['./complaints.component.scss']
})
export class ComplaintsComponent implements OnInit {

  constructor(
       private complaint: ComplaintService,
       private toast: ToastService,
       private loading: LoadingBarService
 ) { }
   public complaints: any = []
  ngOnInit(): void
  {
       this.loading.start()
       this.complaint.getActiveComplaints().subscribe(
            (res) => {
                 this.loading.complete()
                 res.complaints.forEach( (element: any) => {
                      this.complaints.push( ...element)
                 });
            },
            (err) => {
                 this.loading.start()
            }
       )
  }
  completed(complaint: any)
  {
       this.loading.start()
       this.complaint.deactivate({id: complaint.id}).subscribe(
            (res) => {
                 this.loading.complete()
                 const index = this.complaints.indexOf(complaint)
                 this.complaints.splice(index, 1)
                 this.toast.info(res.message)
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
}
