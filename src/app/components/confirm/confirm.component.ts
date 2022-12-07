import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

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

  @Output() actionEvent = new EventEmitter<boolean>()

  ngOnInit(): void {
  }

  closeModal()
  {
          this.display = false
  }
  positive()
  {
       this.actionEvent.emit(true)
  }

  negative()
  {
       this.actionEvent.emit(false)
  }
}
