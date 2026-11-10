@if($errors->any())
    <div class="form-errors" role="alert">
        <strong>يرجى مراجعة الحقول التالية:</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST" class="data-form">
    @csrf
    @if(isset($employee)) @method('PUT') @endif

    @if(isset($employee))
        <div class="form-identity"><span>الرقم الوظيفي</span><strong>{{ $employee->employee_no }}</strong></div>
    @else
        <p class="form-note">سيُنشأ الرقم الوظيفي تلقائيًا بعد حفظ السجل.</p>
    @endif

    <section class="form-section">
        <h2>البيانات الشخصية</h2>
        <div class="form-fields">
            <div class="field"><label for="employee-name">الاسم الكامل <span>*</span></label><input id="employee-name" name="name" value="{{ old('name', $employee->name ?? '') }}" maxlength="255" required autofocus></div>
            <div class="field"><label for="employee-national-id">الرقم الوطني</label><input id="employee-national-id" name="national_id" value="{{ old('national_id', $employee->national_id ?? '') }}" maxlength="50"></div>
            <div class="field"><label for="employee-phone">رقم الهاتف</label><input id="employee-phone" name="phone" type="tel" value="{{ old('phone', $employee->phone ?? '') }}" maxlength="30" autocomplete="tel"></div>
            <div class="field"><label for="employee-birth-date">تاريخ الميلاد</label><input id="employee-birth-date" name="birth_date" type="date" value="{{ old('birth_date', isset($employee?->birth_date) ? $employee->birth_date->format('Y-m-d') : '') }}" max="{{ now()->toDateString() }}"></div>
            <div class="field"><label for="employee-marital-status">الحالة الاجتماعية</label>
                @php($maritalStatus = old('marital_status', $employee->marital_status ?? 'single'))
                <select id="employee-marital-status" name="marital_status">
                    <option value="single" @selected($maritalStatus === 'single')>أعزب</option>
                    <option value="married" @selected($maritalStatus === 'married')>متزوج</option>
                </select>
            </div>
        </div>
    </section>

    <section class="form-section">
        <h2>بيانات العمل</h2>
        <div class="form-fields">
            <div class="field"><label for="employee-job-title">المسمى الوظيفي</label><input id="employee-job-title" name="job_title" value="{{ old('job_title', $employee->job_title ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="employee-department">القسم</label><input id="employee-department" name="department" value="{{ old('department', $employee->department ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="employee-salary">الراتب</label><input id="employee-salary" name="salary" type="number" step="0.01" min="0" value="{{ old('salary', $employee->salary ?? '') }}"></div>
            <div class="field"><label for="employee-hire-date">تاريخ التعيين</label><input id="employee-hire-date" name="hire_date" type="date" value="{{ old('hire_date', isset($employee?->hire_date) ? $employee->hire_date->format('Y-m-d') : '') }}" max="{{ now()->toDateString() }}"></div>
        </div>
    </section>

    <section class="form-section">
        <h2>العنوان</h2>
        <div class="form-fields">
            <div class="field"><label for="employee-state">الولاية</label><input id="employee-state" name="state" value="{{ old('state', $employee->state ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="employee-city">المدينة</label><input id="employee-city" name="city" value="{{ old('city', $employee->city ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="employee-neighborhood">الحي</label><input id="employee-neighborhood" name="neighborhood" value="{{ old('neighborhood', $employee->neighborhood ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="employee-street">الشارع</label><input id="employee-street" name="street" value="{{ old('street', $employee->street ?? '') }}" maxlength="150"></div>
        </div>
    </section>

    <section class="form-section">
        <h2>بيانات الوفاة <small>اختياري</small></h2>
        <div class="form-fields">
            <div class="field"><label for="employee-death-date">تاريخ الوفاة</label><input id="employee-death-date" name="death_date" type="date" value="{{ old('death_date', isset($employee?->death_date) ? $employee->death_date->format('Y-m-d') : '') }}" min="{{ old('birth_date', isset($employee?->birth_date) ? $employee->birth_date->format('Y-m-d') : '') }}" max="{{ now()->toDateString() }}"></div>
            <div class="field"><label for="employee-death-place">مكان الوفاة</label><input id="employee-death-place" name="death_place" value="{{ old('death_place', $employee->death_place ?? '') }}" maxlength="255"></div>
        </div>
    </section>

    <div class="form-actions">
        <button class="form-submit" type="submit">{{ isset($employee) ? 'حفظ التعديلات' : 'حفظ الموظف' }}</button>
        <a class="form-cancel" href="{{ route('employees.index') }}">إلغاء</a>
    </div>
</form>
