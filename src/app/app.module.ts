import { NgModule } from '@angular/core';
import { BrowserModule, Title } from '@angular/platform-browser';
import { NgxEchartsModule } from 'ngx-echarts';
import { FormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS  } from '@angular/common/http';
import { ToastService, AngularToastifyModule } from 'angular-toastify';
import { LoadingBarModule } from '@ngx-loading-bar/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { VerifyPasswordComponent } from './verify-password/verify-password.component';
import { RecoverPasswordComponent } from './recover-password/recover-password.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ChangePasswordComponent } from './change-password/change-password.component';
import { CourseComponent } from './course/course.component';
import { QuestionComponent } from './question/question.component';
import { StudentComponent } from './student/student.component';
import { PrepComponent } from './prep/prep.component';
import { QuizComponent } from './quiz/quiz.component';
import { ComplaintsComponent } from './complaints/complaints.component';
import { DashboardHeaderComponent } from './dashboard-header/dashboard-header.component';
import { HomepageComponent } from './homepage/homepage.component';
import { InstructionsComponent } from './instructions/instructions.component';
import { AddCalculationComponent } from './add-calculation/add-calculation.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { GermanComponent } from './german/german.component';
import { CouseformComponent } from './couseform/couseform.component';
// import { HttpErrorInterceptor } from './http-error.interceptor';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    VerifyPasswordComponent,
    RecoverPasswordComponent,
    DashboardComponent,
    ForgotPasswordComponent,
    ChangePasswordComponent,
    CourseComponent,
    QuestionComponent,
    StudentComponent,
    PrepComponent,
    QuizComponent,
    ComplaintsComponent,
    DashboardHeaderComponent,
    HomepageComponent,
    InstructionsComponent,
    AddCalculationComponent,
    PageNotFoundComponent,
    GermanComponent,
    CouseformComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,
    AngularToastifyModule,
    NgxEchartsModule.forRoot({
     echarts: () => import('echarts')
     }),
     FormsModule,
     LoadingBarModule,
     BrowserAnimationsModule,
  ],
  providers: [
       // {
       //      provide: HTTP_INTERCEPTORS,
       //      useClass: HttpErrorInterceptor,
       //      multi: true
       // }
       ToastService,
       Title
 ],
  bootstrap: [AppComponent]
})
export class AppModule { }
