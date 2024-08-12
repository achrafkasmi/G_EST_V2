<form action="{{ route('attendance.manual.entry') }}" method="POST">
    @csrf
    <label for="unique_code">Enter Attendance Code:</label>
    <input type="text" name="unique_code" id="unique_code" required>
    <button type="submit">Submit</button>
</form>
