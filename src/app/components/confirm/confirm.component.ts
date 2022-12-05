import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-confirm',
  templateUrl: './confirm.component.html',
  styleUrls: ['./confirm.component.css']
})
export class ConfirmComponent implements OnInit {

  constructor() { }

  @Input() display: boolean = true
  @Input() yes: string = ''
  @Input() no: string = ''
  @Input() text: string = "Do you want to continue with the selected action ?"

  ngOnInit(): void {
  }

  closeModal()
  {
          this.display = false
  }
}
