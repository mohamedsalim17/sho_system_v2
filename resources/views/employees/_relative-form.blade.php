<div class="form-section">
    <h2>البيانات الشخصية</h2>
    <div class="form-fields">
        <div class="field"><label for="relative-name">اسم القريب <span>*</span></label><input id="relative-name" name="name" value="{{ old('name', $relative->name) }}" required>@error('name')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-relation">صلة القرابة <span>*</span></label><input id="relative-relation" name="relation" value="{{ old('relation', $relative->relation) }}" required>@error('relation')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-national-id">الرقم الوطني</label><input id="relative-national-id" name="national_id" value="{{ old('national_id', $relative->national_id) }}">@error('national_id')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-phone">الهاتف</label><input id="relative-phone" name="phone" value="{{ old('phone', $relative->phone) }}">@error('phone')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-gender">النوع</label><select id="relative-gender" name="gender"><option value="">غير محدد</option><option value="male" @selected(old('gender', $relative->gender) === 'male')>ذكر</option><option value="female" @selected(old('gender', $relative->gender) === 'female')>أنثى</option></select>@error('gender')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-birth-date">تاريخ الميلاد</label><input id="relative-birth-date" type="date" name="birth_date" value="{{ old('birth_date', $relative->birth_date?->format('Y-m-d')) }}">@error('birth_date')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-death-date">تاريخ الوفاة</label><input id="relative-death-date" type="date" name="death_date" value="{{ old('death_date', $relative->death_date?->format('Y-m-d')) }}">@error('death_date')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-death-place">مكان الوفاة</label><input id="relative-death-place" name="death_place" value="{{ old('death_place', $relative->death_place) }}">@error('death_place')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field field-wide"><label class="checkbox-field"><input type="checkbox" name="is_dependent" value="1" @checked(old('is_dependent', $relative->is_dependent))> مُعال على الموظف</label>@error('is_dependent')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
    </div>
</div>
<div class="form-section">
    <h2>بيانات الحساب البنكي</h2>
    <div class="form-fields">
        <div class="field"><label for="relative-bank-name">اسم البنك</label><input id="relative-bank-name" name="bank_name" value="{{ old('bank_name', $relative->bank_name) }}">@error('bank_name')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-bank-account-name">اسم صاحب الحساب</label><input id="relative-bank-account-name" name="bank_account_name" value="{{ old('bank_account_name', $relative->bank_account_name) }}">@error('bank_account_name')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
        <div class="field"><label for="relative-bank-account-no">رقم الحساب</label><input id="relative-bank-account-no" name="bank_account_no" value="{{ old('bank_account_no', $relative->bank_account_no) }}">@error('bank_account_no')<small class="form-flash-error">{{ $message }}</small>@enderror</div>
    </div>
</div>
