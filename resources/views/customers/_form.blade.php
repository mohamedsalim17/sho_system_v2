@if($errors->any())
    <div class="form-errors" role="alert">
        <strong>يرجى مراجعة الحقول التالية:</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ isset($customer) ? route('customers.update', $customer) : route('customers.store') }}" method="POST" class="data-form">
    @csrf
    @if(isset($customer)) @method('PUT') @endif

    <section class="form-section">
        <h2>البيانات الأساسية</h2>
        <div class="form-fields">
            <div class="field"><label for="customer-name">الاسم الكامل <span>*</span></label><input id="customer-name" name="name" value="{{ old('name', $customer->name ?? '') }}" maxlength="255" required autofocus></div>
            <div class="field"><label for="customer-phone">رقم الهاتف</label><input id="customer-phone" name="phone" type="tel" value="{{ old('phone', $customer->phone ?? '') }}" maxlength="30" autocomplete="tel"></div>
            <div class="field"><label for="customer-gender">الجنس</label>
                <select id="customer-gender" name="gender">
                    <option value="">اختر</option>
                    <option value="ذكر" @selected(old('gender', $customer->gender ?? '') === 'ذكر')>ذكر</option>
                    <option value="انثى" @selected(old('gender', $customer->gender ?? '') === 'انثى')>أنثى</option>
                </select>
            </div>
            <div class="field"><label for="customer-national-id">الرقم الوطني</label><input id="customer-national-id" name="national_id" value="{{ old('national_id', $customer->national_id ?? '') }}" maxlength="50"></div>
            <div class="field"><label for="customer-birth-date">تاريخ الميلاد</label><input id="customer-birth-date" name="birth_date" type="date" value="{{ old('birth_date', $customer->birth_date ?? '') }}" max="{{ now()->toDateString() }}"></div>
            <div class="field"><label for="customer-job">الوظيفة</label><input id="customer-job" name="job" value="{{ old('job', $customer->job ?? '') }}" maxlength="150"></div>
        </div>
    </section>

    <section class="form-section">
        <h2>بيانات السكن والتعليم</h2>
        <div class="form-fields">
            <div class="field"><label for="customer-education">المستوى التعليمي</label>
                @php($education = old('education_level', $customer->education_level ?? ''))
                <select id="customer-education" name="education_level">
                    <option value="">اختر</option>
                    @foreach(['ابتدائي', 'ثانوي', 'جامعي', 'دراسات عليا'] as $level)
                        <option value="{{ $level }}" @selected($education === $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field"><label for="customer-state">الولاية</label><input id="customer-state" name="state" value="{{ old('state', $customer->state ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="customer-city">المدينة</label><input id="customer-city" name="city" value="{{ old('city', $customer->city ?? '') }}" maxlength="150"></div>
            <div class="field field-wide"><label for="customer-address">العنوان بالتفصيل</label><textarea id="customer-address" name="address" rows="3" maxlength="2000">{{ old('address', $customer->address ?? '') }}</textarea></div>
        </div>
    </section>

    <section class="form-section">
        <h2>بيانات الوفاة <small>اختياري</small></h2>
        <div class="form-fields">
            <div class="field"><label for="customer-death-date">تاريخ الوفاة</label><input id="customer-death-date" name="date_of_death" type="date" value="{{ old('date_of_death', $customer->date_of_death ?? '') }}" max="{{ now()->toDateString() }}"></div>
            <div class="field"><label for="customer-death-place">مكان الوفاة</label><input id="customer-death-place" name="place_of_death" value="{{ old('place_of_death', $customer->place_of_death ?? '') }}" maxlength="255"></div>
        </div>
    </section>

    <div class="form-actions">
        <button class="form-submit" type="submit">{{ isset($customer) ? 'حفظ التعديلات' : 'حفظ العميل' }}</button>
        <a class="form-cancel" href="{{ route('customers.index') }}">إلغاء</a>
    </div>
</form>
