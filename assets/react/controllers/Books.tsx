import { FC, useState } from 'react';
import EditableTextField from './EditableTextField';
import EditableMultiSelect from './EditableMultiSelect';

export interface IAuthor {
    id: number;
    fullName: string;
}

export interface IBook {
    id: number;
    name: string;
    description: string;
    published: string;
    authors: IAuthor[];
    bookCover: string;
}

export interface IEditable {
    name: string;
    id: number;
    isActive: boolean;
}

interface IBooksProps {
    books: IBook[];
    options: IAuthor[];
}

const Books: FC<IBooksProps> = ({ books, options }) => {
    //console.log(books);

    const [data, setData] = useState<IBook[]>(() => [...books]);
    const [editable, setEditable] = useState<IEditable>({
        name: null,
        id: null,
        isActive: false,
    });

    const confirmDelete = (e: any) => {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    };

    return (
        <table className="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Published</th>
                    <th>Authors</th>
                    <th>Cover</th>
                    <th style={{ width: '130px' }}>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {data.map((book) => (
                    <tr key={book.id}>
                        <td>
                            <EditableTextField
                                editable={editable}
                                setEditable={setEditable}
                                setData={setData}
                                id={book.id}
                                name={'name'}
                                value={book.name}
                            />
                        </td>
                        <td>
                            <EditableTextField
                                editable={editable}
                                setEditable={setEditable}
                                setData={setData}
                                id={book.id}
                                name={'description'}
                                value={book.description}
                            />
                        </td>
                        <td>
                            <EditableTextField
                                editable={editable}
                                setEditable={setEditable}
                                setData={setData}
                                id={book.id}
                                name={'published'}
                                value={book.published}
                            />
                        </td>
                        <td>
                            <EditableMultiSelect
                                editable={editable}
                                setEditable={setEditable}
                                setData={setData}
                                id={book.id}
                                name={'authors'}
                                value={book.authors}
                                options={options}
                            />
                        </td>
                        <td>
                            {book.bookCover && (
                                <div className="image">
                                    <img src={`/uploads/images/${book.bookCover}`} />
                                    <a href={`/uploads/images/${book.bookCover}`}>View cover</a>
                                </div>
                            )}
                        </td>
                        <td>
                            <a
                                href={`/books/${book.id}`}
                                title="View"
                                type="button"
                                className="btn btn-outline-primary btn-sm"
                            >
                                <i className=" fa-solid fa-eye"></i>
                            </a>
                            &nbsp;
                            <a
                                href={`/books/edit/${book.id}`}
                                title="Edit"
                                type="button"
                                className="btn btn-outline-success btn-sm"
                            >
                                <i className="fa-solid fa-pen-to-square"></i>
                            </a>
                            &nbsp;
                            <a
                                href={`/books/delete/${book.id}`}
                                title="Delete"
                                onClick={confirmDelete}
                                type="button"
                                className="btn btn-outline-secondary btn-sm"
                            >
                                <i className="fa-sharp fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};

export default Books;
