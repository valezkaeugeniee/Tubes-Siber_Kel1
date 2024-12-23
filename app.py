from flask import Flask, render_template, request, redirect, url_for
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import text
import sqlite3

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///students.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

class Student(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    age = db.Column(db.Integer, nullable=False)
    grade = db.Column(db.String(10), nullable=False)

    def __repr__(self):
        return f'<Student {self.name}>'

@app.route('/')
def index():
    # RAW Query
    students = db.session.execute(text('SELECT * FROM student')).fetchall()
    return render_template('index.html', students=students)

@app.route('/add', methods=['POST'])
def add_student():
    name = request.form['name']
    age = request.form['age']
    grade = request.form['grade']
    
    try:
        age = int(age)
                
        if age < 0:
            return redirect (url_for('index'))
                
    except ValueError:
            return redirect (url_for('index'))


    # Kode dari gambar
    new_student = Student(name=name, age=age, grade=grade)
    db.session.add(new_student)
    db.session.commit()
            


    # connection = sqlite3.connect('instance/students.db')
    # cursor = connection.cursor()

    # RAW Query
    db.session.execute(
         text("INSERT INTO student (name, age, grade) VALUES (:name, :age, :grade)"),
         {'name': name, 'age': age, 'grade': grade}
     )
    db.session.commit()
    db.session.close()
    return redirect(url_for('index'))


@app.route('/delete/<string:id>', methods=['POST']) 
# def delete_student(id):
#     # RAW Query
#     db.session.execute(text(f"DELETE FROM student WHERE id={id}"))
#     db.session.commit()
#     return redirect(url_for('index'))

def delete_student(id):
    student = Student.query.get(id)  # Cari data berdasarkan ID
    if not student:
        return "Student not found", 404  # Jika ID tidak ada, kembalikan error

    db.session.delete(student)  # Hapus data
    db.session.commit()
    return redirect('/')


@app.route('/edit/<int:id>', methods=['GET', 'POST'])
def edit_student(id):
    if request.method == 'POST':
        name = request.form['name']
        age = request.form['age']
        grade = request.form['grade']
        
        # RAW Query
        db.session.execute(text(f"UPDATE student SET name='{name}', age={age}, grade='{grade}' WHERE id={id}"))
        db.session.commit()
        return redirect(url_for('index'))
    else:
        # RAW Query
        student = db.session.execute(text(f"SELECT * FROM student WHERE id={id}")).fetchone()
        return render_template('edit.html', student=student)

# if __name__ == '__main__':
#     with app.app_context():
#         db.create_all()
#     app.run(debug=True)
if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(host='0.0.0.0', port=5000, debug=True)

